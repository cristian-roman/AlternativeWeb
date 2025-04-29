var beginning="https://localhost/";

var messageInput = document.getElementById("toSendMessage");
var sendButton = document.getElementById("sendButton");

var lastChartID = -1;
var lastPostID = -1;
var isAvailableConversation = false;

var thisUserID = -1;
var thisUserUsername = "";

if(lastChartID===-1)
{
  messageInput.placeholder="Conversation not selected...";
  messageInput.disabled = true;
  sendButton.disabled = true;
}

function SelectYourConvo()
{
    var create_selectConvoButton = document.getElementById("create-selectConvoButton");

    thisUserUsername = create_selectConvoButton.getAttribute("thisUserUsername");
    lastPostID = create_selectConvoButton.getAttribute("postID");
    thisUserID = create_selectConvoButton.getAttribute("thisUserID");

    var response = SelectConvo(lastPostID, thisUserID);
    if(response!=-1) ///the chart exists and it has uid=response so show it up
    {
      lastChartID = response;
      
      messageInput.placeholder="Type your point of view...";
      messageInput.disabled = false;
      sendButton.disabled = false;
    
      isAvailableConversation = true;

      GetConvo(lastChartID);
    }
    else
    {
      GetInitialConvoPage(lastPostID, thisUserID, thisUserUsername);

      messageInput.placeholder="Type your point of view...";
      messageInput.disabled = false;
      sendButton.disabled = false;

      isAvailableConversation = true;
      lastChartID = -321;
    }
}

function GetInitialConvoPage()
{
  var url = beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/initialConvoPage.php";
  document.getElementById("messages").innerHTML='<iframe src="'+url+'" style="width:100%; height:100%; overflow: hidden; border:none;" scrolling="no"  seamless="seamless"></iframe>';
}

function SendMessage()
{
    if( messageInput.value!="")
    {
      if(lastChartID===-321) ///provine din yourConvo
      {
          CreateConvo();
          lastChartID = SelectConvo(lastPostID, thisUserID);
          UpdateDiscussionCounter(lastPostID);
      }
      if(isAvailableConversation==true)
      { 
        var url = beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/sendChartMessage.php";
        var params ="chartID="+lastChartID+"&thisUserID="+thisUserID+"&thisUserUsername="+thisUserUsername+"&message="+messageInput.value+"&lastPostID="+lastPostID;

        var response = LoadPHP(url,params);
        
        alert(response);
        messageInput.value="";

        UpdateCharts(lastChartID, thisUserID);

        GetConvo(lastChartID);
      }
      else
      {
        alert("Can't send the message because the conversation is full, is not selected");
      }
    }
    else
    {
      alert("Can't send the message because the field is empty.");
    }
}

function UpdateCharts(lastChartID, thisUserID)
{
  var isUserInConvo = IsUserInConvo(lastChartID, thisUserID);
  if(isUserInConvo == "false")
  {
    var membersCounter = GetMembersCounter(lastChartID);
    membersCounter++;
    var url = beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/updateChart.php";
    var params ="chartID="+lastChartID+"&column=Members_Counter&newValue="+membersCounter;

    LoadPHP(url, params);

    var column="Empty";
    if(membersCounter==2)
    {
        column = "Second_User_ID";
    }
    else if(membersCounter==3)
    {
        column = "Third_User_ID";
    }

    params ="chartID="+lastChartID+"&column="+column+"&newValue="+thisUserID;

    LoadPHP(url, params);
  }
}

function IsUserInConvo(lastChartID, thisUserID)
{
  var url = beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/isUserInConvo.php";
  var params ="lastChartID="+lastChartID+"&thisUserID="+thisUserID;

  var response = LoadPHP(url, params);
  return response;
}

function GetMembersCounter(lastChartID)
{
  var url = beginning+"/AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/chartMembersCounter.php";
  var params ="lastChartID="+lastChartID;

  var result = LoadPHP(url, params);

  return result;
}


function UpdateDiscussionCounter(lastPostID)
{
    var discussions = GetDiscussionCounter(lastPostID);

    discussions++;
    var url= beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/updateDiscussion.php";
    var params = "lastPostID="+lastPostID+"&column=Discussions&newValue="+discussions;

    LoadPHP(url,params);
}

function GetDiscussionCounter(lastPostID)
{
  var url=beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/getDiscussionCounter.php";
  var params="lastPostID="+lastPostID;

  var response = LoadPHP(url, params);
  return response;
}

function CreateConvo()
{
  var url = beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/createChart.php";
  var params ="postID="+lastPostID+"&thisUserID="+thisUserID;
  
  response = LoadPHP(url, params);
}

function SelectConvo(lastPostID, thisUserID)
{
    var url = beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/database-comunication/selectYourConvoChart.php";
    var params ="postID="+lastPostID+"&thisUserID="+thisUserID;

    var response = -3123;
    
    response = LoadPHP(url, params);

    return response;
}


function LoadConvo(chart_ID)
{
   
    var thisButton = document.getElementById(chart_ID);

    lastChartID = chart_ID;
    thisUserID = thisButton.getAttribute("thisUserID");
    lastPostID = thisButton.getAttribute("postID");
    thisUserUsername = thisButton.getAttribute("thisUserUsername");

    var membersCounter = thisButton.getAttribute("membersCounter");
    var firstUserID = thisButton.getAttribute("firstUserID");
    var secondUserID = thisButton.getAttribute("secondUserID");
    var thirdUserID = thisButton.getAttribute("thirdUserID");

    if(membersCounter < 3 || ( (firstUserID===thisUserID) || (secondUserID==thisUserID) || (thirdUserID==thisUserID)))
    {
      messageInput.placeholder="Type your point of view...";
      messageInput.disabled = false;
      sendButton.disabled = false;

      isAvailableConversation = true;
    }
    else
    {
      messageInput.value="";
      messageInput.disabled = true;
      sendButton.disabled = true;
      messageInput.placeholder="This conversation is full...";

      isAvailableConversation = false;
    }

    GetConvo(lastChartID);
}

/*helpers*/

function LoadPHP(url, params)
{
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.setRequestHeader("Content-length", params.length);
  xhttp.setRequestHeader("Connection", "close");
  xhttp.send(params);
 
  return xhttp.responseText;
}


function GetConvo(chart_ID)
{
  var url = beginning+"AlternativeWebSite(1.0)/html/discussions/discussion-hub/loadMessagesPool.php?chartID="+chart_ID;
  document.getElementById("messages").innerHTML='<iframe src="'+url+'" style="width:100%; height:100%; overflow: hidden; border:none;" scrolling="no"  seamless="seamless"></iframe>';
}



