/**
 * Takes text away from a field
 */
function clearText(e, defaultText)
{
    var target = window.event ? window.event.srcElement : e ? e.target : null;

    if (!target) return;

    if (target.value == defaultText)
    {
        target.value = '';
    }
}

/**
 * Restores a field's text.
 */
function restoreText(e, defaultText)
{
    var target = window.event ? window.event.srcElement : e ? e.target : null;

    if (!target) return;

    if (target.value == '' && defaultText)
    {
        target.value = defaultText;
    }
}

/**
 * Sets a target's text grey, if the text matches defaultText.
 */
function setTextGreyIf(e, defaultText)
{
    var target = window.event ? window.event.srcElement : e ? e.target : null;

    if (!target) return;

	if (target.value == defaultText)
	{
		target.style.color = "grey";
	}
	else
	{
		target.style.color = "black";
	}
}

function setTextBlack(e)
{
    var target = window.event ? window.event.srcElement : e ? e.target : null;

    if (!target) return;

    target.style.color = "black";
}

function validateSearch(e)
{
    t = document.Search.Model.value;

	if (t == "Search" || t == "")
	{
		// if no text is searched for, get everything.
		document.Search.Model.value = "";
		document.Search.submit();
	}
	else
	{
		// Fixed it. changed the variable name in search.php from search to search_text and
		// changed form method from POST to GET. Now you can also hit 'enter' to search
		// instead of clicking the magnifying glass. --Rob
		document.Search.submit();
	}
}
