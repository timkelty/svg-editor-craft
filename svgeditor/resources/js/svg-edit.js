// jQuery svgEdit Plugin
(function( $ ) {
  var settings = {

  };

  var svgCanvases = {};

  var methods = {
    init: function( options ) {

      this.each(function() {
        var id = this.id;
        var $this = $(this);
        var $iframe = $this.find('iframe');
        var $textarea = $this.find('textarea');
        var code = $textarea.val();
        var $form = $this.parents('[id="entry-form"]');
        var frame = $iframe[0];
        svgCanvases[id] = new window.embedded_svg_edit(frame);

        // Set src
        $iframe.prop('src', $iframe.data('src'));

        // Load saved code
        $iframe.on('load', function(event) {
          if (code) {
            svgCanvases[id].setSvgString(code);
          }
        });

        // Dump into input on save
        $form.on('submit', function(event) {
          event.preventDefault();
          svgCanvases[id].getSvgString()(function(data, error) {
            if (error) {
              alert(error);
            } else {
              $textarea.val(data);
              $form[0].submit();
            }
          });
        });

      });

      return this;
    },
    destroy: function( ) {

      this.each(function() {

        var $this = $(this),
            data = $this.data( 'svgEdit' );

        // Remove created elements, unbind namespaced events, and remove data
        $(document).unbind( '.svgEdit' );
        data.svgEdit.remove();
        $this.unbind( '.svgEdit' )
        .removeData( 'svgEdit' );

      });

      return this;
    },
    options: function( options ) {

      this.each(function() {
        var $this = $(this),
            // don't use our getData() function here
            // because we want an object regardless
            data = $this.data( 'svgEdit' ) || {},
            opts = data.options || {};

        // deep extend (merge) default settings, per-call options, and options set with:
        // html10 data-svgEdit options JSON and $('selector').svgEdit( 'options', {} );
        opts = $.extend( true, {}, $.fn.svgEdit.defaults, opts, options || {} );
        data.options = opts;
        $.data( this, 'svgEdit', data );
      });

      return this;
    }
  };

  var protoSlice = Array.prototype.slice;

  $.fn.svgEdit = function( method ) {

    if ( methods[method] ) {
      return methods[method].apply( this, protoSlice.call( arguments, 1 ) );
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.fn.svgEdit' );
    }

  };

  $.extend($.fn.svgEdit, {
    defaults: settings
  });

  function getData(el) {
    var svgEdit, opts,
        $this = $(el),
        data = $this.data( 'svgEdit' ) || {};

    if (!data.svgEdit) { return false; }

    return data;
  }

})( jQuery );
