( function( window, document ) {
  function construction_hub_keepFocusInMenu() {
    document.addEventListener( 'keydown', function( e ) {
      const construction_hub_nav = document.querySelector( '.sidenav' );
      if ( ! construction_hub_nav || ! construction_hub_nav.classList.contains( 'open' ) ) {
        return;
      }
      const elements = [...construction_hub_nav.querySelectorAll( 'input, a, button' )],
        construction_hub_lastEl = elements[ elements.length - 1 ],
        construction_hub_firstEl = elements[0],
        construction_hub_activeEl = document.activeElement,
        tabKey = e.keyCode === 9,
        shiftKey = e.shiftKey;
      if ( ! shiftKey && tabKey && construction_hub_lastEl === construction_hub_activeEl ) {
        e.preventDefault();
        construction_hub_firstEl.focus();
      }
      if ( shiftKey && tabKey && construction_hub_firstEl === construction_hub_activeEl ) {
        e.preventDefault();
        construction_hub_lastEl.focus();
      }
    } );
  }
  construction_hub_keepFocusInMenu();
} )( window, document );