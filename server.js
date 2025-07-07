const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 8080 });

setInterval(() => {
  wss.clients.forEach(ws => {
    ws.send(JSON.stringify({
      id: 2,
      disponivel: Math.random() > 0.3
    }));
  });
}, 3000);