
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('access_token');
const game = urlParams.get('game');

config = {
    ws_url: "ws://localhost:8080?access_token="+token+"&game="+game
}