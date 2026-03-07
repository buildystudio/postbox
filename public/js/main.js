(function() {

// Feedback nach Zeitablauf ausblenden

setTimeout(function() {
	removeElementsBy('.error, .success');
}, 3000);

// HTML Elemente anhand eines CSS Selektors entfernen

function removeElementsBy(selector) {
	$$(selector).forEach(function(el) {
		el.remove();
	});
}

// Hilfsfunktionen

var $ = document.querySelector.bind(document), 
		$$ = document.querySelectorAll.bind(document);
		
})();