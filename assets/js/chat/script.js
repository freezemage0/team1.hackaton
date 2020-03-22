;(function() {

    $(document).on('click', '.message-send', (e) => {

        let message = document.querySelector('.message-input').value;

        if (message.length === 0) {
            return false;
        }

        let formData = new FormData();
        formData.append('MESSAGE_TEXT', message);

        let xhr = new XMLHttpRequest();
        xhr.open('post', '/chat/send');
        xhr.send(formData);

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                alert('Сообщение вышло на свет =))');
            }
        }

    });

    class Chat {
    }

    class Ajax {
    }

})();