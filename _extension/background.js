chrome.browserAction.onClicked.addListener(function(activeTab) {
  var newURL = "https://empirestatebuilding.herokuapp.com/";
  chrome.tabs.create({ url: newURL });
});