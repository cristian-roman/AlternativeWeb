var upImage = document.getElementById('Up');
var x = 1;

var beginning="https://192.168.1.19/";
function GoToPostingPage()
{
    var redirectButton = document.getElementById("goToPostingPageButton");

    thisUserUsername = redirectButton.getAttribute("thisUserUsername");
    thisUserID = redirectButton.getAttribute("thisUserID");

    window.location.href = beginning+"/AlternativeWebSite(1.0)/html/discussions/post-discussion/index.php?thisUserID="+thisUserID+"&thisUserUsername="+thisUserUsername;
}

function changeImage()
{
    if(x==1)
    {
        upImage.src="../../images/Up-selected.png";
    }
    else
    {
        upImage.src="../../images/Up-unselected.png";
    }
    x=(x+1)%2;
}