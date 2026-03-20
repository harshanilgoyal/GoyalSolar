import DataService         from './DataService';
import LoggingService      from './LoggingService';

// eslint-disable-next-line camelcase
declare let wc_address_i18n_params: any;

class ParsleyService {
    /**
     * @type {any}
     * @private
     */
    private _parsley: any;

    private readonly _parsleyConfig: any;

    /**
     *
     */
    constructor() {
        // Attach errors to the outer parent so that select arrow styling isn't effected by dynamic height of cfw-input-wrap
        this._parsleyConfig = {
            errorsContainer( parsleyElement ) {
                return parsleyElement.$element.parent( '.cfw-input-wrap' ).parent( 'div' );
            },
        };

        this.setParsleyValidators();
    }

    /**
     *
     */
    setParsleyValidators(): void {
        // An instance of self that we can use without
        // worrying about scoping issues with functions
        const self = this;

        /**
         * Init Parsley
         */
        jQuery( window ).on( 'load', () => {
            this.parsley = ( <any>window ).Parsley;
            this.parsley.on( 'form:error', () => {
                jQuery( document.body ).trigger( 'cfw-remove-overlay' );
                LoggingService.logEvent( 'Fired cfw-remove-overlay event.' );
            } );

            try {
                // Parsley locale
                ( <any>window ).Parsley.setLocale( DataService.getSetting( 'parsley_locale' ) );
            } catch {
                const settings = DataService.getSettings();
                console.log( `CheckoutWC: Could not load Parsley translation domain (${settings.parsley_locale})` );
            }

            DataService.checkoutForm.parsley( this._parsleyConfig );

            // If we don't call this here, changing the state
            // field to 'Select an option' doesn't fire validation
            ( <any>window ).setTimeout( () => {
                self.refreshParsley();
            } );
        } );

        /**
         * There's a lot going on here, but here's essentially what we're doing.
         *
         * If the state field changes, we check to see what field type it is and do the following:
         * - Add correct classes to field parent wrap
         * - Make any changes to the Parsley validation
         * - Refresh Parsley
         *
         * The fields we are handling in this routine are state, city, and postcode for both address types.
         *
         * Lastly, we do this in a timer because we can't guarantee that WooCommerce will be done making their changes
         * before this runs. So by delaying 100ms, we ensure that they are completely done before we do our stuff.
         */
        jQuery( document.body ).bind( 'country_to_state_changed', ( event, country, wrapper ) => {
            if ( typeof wrapper === 'undefined' ) {
                return;
            }

            ( <any>window ).setTimeout( () => {
                const localeJson = wc_address_i18n_params.locale.replace( /&quot;/g, '"' );
                const locale = JSON.parse( localeJson );

                let thisLocale;

                if ( typeof locale[ country ] !== 'undefined' ) {
                    thisLocale = locale[ country ];
                } else {
                    thisLocale = locale.default;
                }

                // Find the actual field wrapper
                // eslint-disable-next-line no-param-reassign
                const stateWrapper = wrapper.find( '#billing_state, #shipping_state' ).parent( '.cfw-input-wrap' );
                const cityWrapper = wrapper.find( '#billing_city, #shipping_city' ).parent( '.cfw-input-wrap' );
                const postcodeWrapper = wrapper.find( '#billing_postcode, #shipping_postcode' ).parent( '.cfw-input-wrap' );

                stateWrapper.find( '#billing_state, #shipping_state' ).each( function () {
                    const fieldLocale = jQuery.extend( true, {}, locale.default.state, thisLocale.state );

                    const group = jQuery( this ).attr( 'id' ).split( '_' )[ 0 ];

                    if ( jQuery( this ).is( 'select' ) ) {
                        // Setup data again
                        jQuery( this ).attr( 'field_key', 'state' )
                            .addClass( 'garlic-auto-save' )
                            .trigger( 'cfw-after-field-country-to-state-changed' );
                        LoggingService.logEvent( 'Fired cfw-after-field-country-to-state-changed event.' );

                        stateWrapper.addClass( 'cfw-select-input' )
                            .removeClass( 'cfw-hidden-input' )
                            .removeClass( 'cfw-text-input' )
                            .addClass( 'cfw-floating-label' );
                    } else if ( jQuery( this ).attr( 'type' ) === 'text' ) {
                        jQuery( this ).attr( 'field_key', 'state' )
                            .addClass( 'garlic-auto-save' )
                            .addClass( 'input-text' )
                            .trigger( 'cfw-after-field-country-to-state-changed' );
                        LoggingService.logEvent( 'Fired cfw-after-field-country-to-state-changed event.' );

                        stateWrapper.addClass( 'cfw-text-input' )
                            .removeClass( 'cfw-hidden-input' )
                            .removeClass( 'cfw-select-input' )
                            .addClass( 'cfw-floating-label' );
                    } else {
                        jQuery( this ).addClass( 'hidden' );

                        stateWrapper.addClass( 'cfw-hidden-input' )
                            .removeClass( 'cfw-text-input' )
                            .removeClass( 'cfw-select-input' )
                            .removeClass( 'cfw-floating-label' );
                    }

                    // Handle required toggle
                    // We have to add the parsley attributes here because the field is
                    // recreated and thus loses anything that was previously there.
                    if ( fieldLocale.required ) {
                        jQuery( this )
                            .attr( 'data-parsley-trigger', 'keyup change focusout' )
                            .attr( 'data-parsley-group', group )
                            .attr( 'data-parsley-required', 'true' );
                    } else {
                        jQuery( this )
                            .removeAttr( 'data-parsley-trigger' )
                            .removeAttr( 'data-parsley-group' )
                            .attr( 'data-parsley-required', 'false' );
                    }
                } );

                cityWrapper.find( '#billing_city, #shipping_city' ).each( function () {
                    if ( !jQuery( this ).is( ':visible' ) ) {
                        jQuery( this ).attr( 'data-parsley-required', 'false' );
                    } else if ( jQuery( this ).is( ':visible' ) ) {
                        jQuery( this ).attr( 'data-parsley-required', 'true' );
                    }
                } );

                postcodeWrapper.find( '#billing_postcode, #shipping_postcode' ).each( function () {
                    if ( !jQuery( this ).is( ':visible' ) || jQuery( this ).siblings( 'label' ).find( '.optional' ).length ) {
                        jQuery( this ).attr( 'data-parsley-required', 'false' );
                    } else if ( jQuery( this ).is( ':visible' ) ) {
                        jQuery( this ).attr( 'data-parsley-required', 'true' );
                    }
                } );

                self.refreshParsley();
            } );
        } );
    }

    refreshParsley(): void {
        // Remove existing parsley errors.
        DataService.checkoutForm.find( '.parsley-errors-list' ).remove();

        // Re-register all the elements
        DataService.checkoutForm.parsley().refresh();
    }

    destroy(): void {
        // Destroy all the parsley!
        DataService.checkoutForm.parsley().destroy();
    }

    /**
     * @returns {any}
     */
    get parsley(): any {
        return this._parsley;
    }

    /**
     * @param value
     */
    set parsley( value: any ) {
        this._parsley = value;
    }
}

export default ParsleyService;
