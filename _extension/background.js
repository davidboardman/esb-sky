chrome.browserAction.onClicked.addListener(function(activeTab) {
  var newURL = "http://tinktank.it/empire/";
  chrome.tabs.create({ url: newURL });
});