var latestServerQuery = "undefined";

function getCurrentQuery() {


function getArticle() {

	// Create new JS element
	var jsel = document.createElement('SCRIPT');

	if (getCurrentQuery()!=latestServerQuery && getCurrentQuery()) {
		divSummary = document.getElementById('summary');
		divSummary.innerHTML = '<p class="big">Working...</p>';

		jsel.type = 'text/javascript';
		jsel.src = '/article.php?q=' + getCurrentQuery();

		// Append JS element (therefore executing the 'AJAX' call)
		document.body.appendChild (jsel);

		latestServerQuery = getCurrentQuery();

	setTimeout('getArticle();',800);
}
