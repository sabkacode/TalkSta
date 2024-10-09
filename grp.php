<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    echo '<script>alert("You are not logged in!!\nPlease log in first.");</script>';
    header("refresh:0; url=https://talksta.000.pe");
    exit();
} else {
    include 'dbcon.php';
    include 'header.php';
    $un = $_SESSION['user_name'];
    echo '
    <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
                    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                    <title>Chat Application</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    #chat { width: 300px; margin: 0 auto; }
                    #chat-box { border: 1px solid #ccc; padding: 10px; height: 200px; overflow-y: scroll; }
                    #chat-form { margin-top: 10px; }
                    #chat-form input { padding: 10px; width: 80%; }
                    #chat-form button { padding: 10px; width: 18%; }
                </style>
            </head>
            <body>
                <div id="chat">
                    <div id="chat-box"></div>
                    <form id="chat-form">
                        <input type="text" id="username" placeholder="Username" required>
                        <input type="text" id="message" placeholder="Type your message..." required>
                        <button type="submit">Send</button>
                    </form>
                </div>

                <script>
                    document.getElementById("chat-form").addEventListener("submit", function(e) {
                        e.preventDefault();
                        const username = document.getElementById("username").value;
                        const message = document.getElementById("message").value;

                        fetch("send_message.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ username, message })
                        }).then(response => response.json()).then(data => {
                            if (data.success) {
                                document.getElementById("message").value = "";
                                loadMessages();
                            }
                        });
                    });

                    function loadMessages() {
                        fetch("get_messages.php")
                            .then(response => response.json())
                            .then(data => {
                                const chatBox = document.getElementById("chat-box");
                                chatBox.innerHTML = "";
                                data.messages.forEach(message => {
                                    const messageElement = document.createElement("div");
                                    messageElement.textContent = `${message.username}: ${message.message}`;
                                    chatBox.appendChild(messageElement);
                                });
                            });
                    }

                    setInterval(loadMessages, 1000);
                    loadMessages();
                </script>
                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                <script src="https://kit.fontawesome.com/02f4bd7d60.js" crossorigin="anonymous"></script>
            </body>
        </html>
    ';
}
?>
