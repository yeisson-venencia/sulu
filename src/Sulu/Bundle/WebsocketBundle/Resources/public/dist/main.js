require.config({paths:{suluwebsocket:"../../suluwebsocket/js","websocket-manager":"../../suluwebsocket/js/component/websocket-manager/main","websocket/abstract":"../../suluwebsocket/js/component/websocket-manager/client/client","websocket/client":"../../suluwebsocket/js/component/websocket-manager/client/websocket","websocket/fallback":"../../suluwebsocket/js/component/websocket-manager/client/ajax","websocket/wrapper":"../../suluwebsocket/js/component/websocket-manager/client/wrapper"}}),define(["config","websocket-manager"],function(a,b){return{name:"Sulu Websocket Bundle",initialize:function(){"use strict";b.init(a.get("sulu.websocket.server"),a.get("sulu.websocket.apps"))}}});