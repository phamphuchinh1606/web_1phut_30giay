if ((typeof InputFortmat) === 'undefined') { InputFortmat = {}; }

InputFortmat.formatNumber = function (inputs) {
    inputs.each(function(){
        var $this = $( this );
        // Get the value.
        var input = $this.val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        if(input){
            input = input ? parseInt( input, 10 ) : 0;
            $this.val( function() {
                // return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                return input.toLocaleString( "en-US" );
            } );
        }
    });
    inputs.on( "keyup", function( event ) {
        // When user select text in the document, also abort.
        var selection = window.getSelection().toString();
        if ( selection !== '' ) {
            return;
        }
        // When the arrow keys are pressed, abort.
        if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
            return;
        }
        var $this = $( this );
        // Get the value.
        var input = $this.val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;
        $this.val( function() {
            // return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
            return input.toLocaleString( "en-US" );
        } );
    } );
};

InputFortmat.originalNumber = function (value){
    return value.replace(/[($)\s\,._\-]+/g, ''); // Sanitize the values.
};

InputFortmat.formatDouble = function (inputs){
    inputs.each(function(){
        var $this = $( this );
        // Get the value.
        var input = $this.val();
        var input = input.replace(/[^\d\.]+/g, "");
        if(input){
            if(!input.endsWith('.') || input.match(/\./g).length > 1){
                input = input ? parseFloat( input ) : 0;
            }
            $this.val( function() {
                // return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                return input.toLocaleString( "en-US" );
            } );
        }
    });
    inputs.on( "keyup", function( event ) {
        // When user select text in the document, also abort.
        var selection = window.getSelection().toString();
        if ( selection !== '' ) {
            return;
        }
        // When the arrow keys are pressed, abort.
        if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
            return;
        }
        var $this = $( this );
        // Get the value.
        var input = $this.val();
        var input = input.replace(/[^\d\.]+/g, "");
        if(!input.endsWith('.') || input.match(/\./g).length > 1){
            input = input ? parseFloat( input ) : 0;
        }
        $this.val( function() {
            // return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
            return input.toLocaleString( "en-US" );
        } );
    } );
};

InputFortmat.originalDouble = function (value){
    return value.replace(/[($)\s\,_\-]+/g, ''); // Sanitize the values.
};

(function($, undefined) {
    "use strict";
    // When ready.
    $(function() {
        var $form = $( "body" );
        var numberInputs = $form.find("input.number");
        InputFortmat.formatNumber(numberInputs);

        var doubleInputs = $form.find("input.double");
        InputFortmat.formatDouble(doubleInputs);


        /**
         * ==================================
         * When Form Submitted
         * ==================================
         */
        $form = $('form');
        $form.on( "submit", function( event ) {

            var $this = $( this );
            var $input = $this.find("input.number");
            $input.each(function(index , inputItem){
                let value = $(inputItem).val();
                if(value != ''){
                    $(inputItem).val(value.replace(/[($)\s\,_\-]+/g, ''));
                }
            });

            var $input = $this.find("input.double");
            $input.each(function(index , inputItem){
                let value = $(inputItem).val();
                if(value != ''){
                    $(inputItem).val(value.replace(/[($)\s\,_\-]+/g, ''));
                }
            });
            // var arr = $this.serializeArray();
            //
            // for (var i = 0; i < arr.length; i++) {
            //     arr[i].value = arr[i].value.replace(/[($)\s\._\-]+/g, ''); // Sanitize the values.
            // };
            // event.preventDefault();
            // return false;
        });

    });
})(jQuery);
