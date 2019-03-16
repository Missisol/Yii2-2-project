'use strict';

const webSocketPort = wsPort ? wsPort : 8080;
const conn = new WebSocket('ws://localhost:' + webSocketPort);
const user = userName;
const avatar = userAvatar;

conn.onopen = (e) => {
  console.log("Connection established!");
};

conn.onerror = (e) => {
  console.log("Connection failed!");
};

(($) => {
  $(() => {
    /**
     * Sens message when an 'onclick' event occurs
     */
    $('#chatSubmit').on('click', () => {
      const $title = $('#chatTitle');
      const $elem = $('#bodyMessage');
      const title = $title.val();
      const elemText = $elem.val();

      conn.send(`${user}::${title}::${elemText}::${avatar}`);
      $title.val('');
      $elem.val('');
    });

    /**
     * Receives message and places it into DOM-elements
     * @param e
     */
    conn.onmessage = (e) => {
      const data = e.data.split(/::/);

      const chat = new ChatBox(data);
      chat.addMessageToBox();
      chat.addMessageToDropdownBox();
    };

     /**
     * Class for creating message containers
     */
    class ChatBox {
      constructor([senderId, senderName, title, message, image, receiverId]) {
        this.senderId = senderId;
        this.senderName = senderName;
        this.title = title;
        this.message = message;
        this.image = image;
        this.receiverId = receiverId;
      }

      /**
       * Adds received message to all messages container
       */
      addMessageToBox() {
        const $allMessagesBox = $('#allMessages');
        const $chatBox = $(`ul#chatMessages_${this.title}`);
        console.log($chatBox);
        if ($chatBox.length !== 0) {
          const $oneMessage = $('<li />', {
            class: 'oneMessage',
            text: `User ${this.senderName}:  ${this.message}`,
          });
          $chatBox.prepend($oneMessage);
        } else {
          const $title = $('<h5 />', {
            text: `Thread: project ${this.title}`
          });
          const $chatBox = $('<ul />', {
            class: 'chatMessages',
            id: `chatMessages_${this.title}`,
          });
          $allMessagesBox.append($title).append($chatBox);
          const $oneMessage = $('<li />', {
            class: 'oneMessage',
            text: `User ${this.senderName}:  ${this.message}`,
          });
          $chatBox.prepend($oneMessage);
        }
      }

      /**
       * Adds received message to dropdown container
       */
      addMessageToDropdownBox() {
        if (this.senderId !== this.receiverId) {
          const $li = $('<li />');
          const $a = $('<a />', {href: '#'});
          const $div = $('<div />', {class: 'pull-left'});
          const $img = $('<img />', {
            src: this.image,
            class: 'img-circle',
            alt: 'User Image',
          });
          $div.append($img);
          const $h4 = $('<h4 />').text(`nickname: ${this.senderName}`);
          const $small = $('<small />');
          const $i = $('<i />', {class: 'fa fa-clock-o'});
          $small.append($i).append(new Date().toLocaleString('ru', {
            day: 'numeric',
            month: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
          }));
          $h4.append($small);
          const $p = $('<p />', {class: 'messageText'}).text(this.message);
          $a.append($div).append($h4).append($p);
          $li.append($a);
          $('ul.menu').prepend($li);

          const cnt = $('li.messages-menu ul.menu li').length;
          $('li.messages-menu span.label-success').text(cnt);
          $('li.messages-menu li.header').text(`You have ${cnt} messages`);
        }
      }
    }
  });
})(jQuery);



