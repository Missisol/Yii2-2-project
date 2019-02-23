var webSocketPort = wsPort ? wsPort : 8080;
var conn = new WebSocket('ws://localhost:' + webSocketPort);

conn.onopen = function (e) {
  console.log("Connection established!");
};

conn.onerror = function (e) {
  console.log("Connection failed!");
};

$(function () {
  $('#chatSubmit').on('click', function () {
    const $elem = $('#bodyMessage');
    const elemText = $elem.val();
    const name = $('span.userName').text();
    conn.send(`${name}::${elemText}`);
    $elem.val('');
  });
});

conn.onmessage = function (e) {
  $(function () {
    const data = e.data.split(/::/);
    const userId = data[0];
    const name = data[1];
    const message = data[2];
    const user = $('span.userName').text();

    const $chatBox = $('#chatMessages');
    const $oneMessage = $('<li />', {
      class: 'oneMessage',
      text: `User ${name}:  ${message}`,
    });
    $chatBox.prepend($oneMessage);

    if(name !== user) {
      const $li = $('<li />');
      const $a = $('<a />', {href: '#'});
      const $div = $('<div />', {class: 'pull-left'});
      const $img = $('<img />', {
        src: `/assets/29af8489/img/${name}.jpg`,
        class: 'img-circle',
        alt: 'User Image',
      });
      $div.append($img);
      const $h4 = $('<h4 />').text(`user ID: ${userId}`);
      const $small = $('<small />');
      const $i = $('<i />', {class: 'fa fa-clock-o'});
      $small.append($i).append(new Date().toLocaleString('ru', {
        day: 'numeric',
        month: 'numeric',
        hour: 'numeric',
        minute: 'numeric',}));
      $h4.append($small);
      const $p = $('<p />', {class: 'messageText'}).text(message);
      $a.append($div).append($h4).append($p);
      $li.append($a);
      $('ul.menu').prepend($li);

      const cnt = $('li.messages-menu ul.menu li').length;
      $('li.messages-menu span.label-success').text(cnt);
      $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
    }
  });
};


