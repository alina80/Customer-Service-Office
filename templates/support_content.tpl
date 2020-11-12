<div class="row" id="content">
    <div class="col-md-4 colHeight">
        <div class="page-header">
            <h3>My threads</h3>
        </div>
        <div>
            <table class="table">
                <tr>
                    <th>Subject</th>
                </tr>
                {{conversations}}
            </table>
        </div>
    </div>
    <div class="col-md-4 colHeight">
        <div class="page-header">
            <h3>Open threads</h3>
        </div>
        <div>
            <table class="table">
                <tr>
                    <th>Subject</th>
                    <th></th>
                </tr>
                {{openConversations}}
            </table>
        </div>
    </div>
    <div class="col-md-4 colHeight">
        <div class="page-header">
            <h3>Chat</h3>
        </div>
        <div>
            <table class="table">
                <tr>
                    <th>Sender</th>
                    <th>Message</th>
                </tr>
                {{messages}}
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <br>
        <hr>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <legend>Add a topic</legend>
        <hr>
        <form method="post" action="../controllers/ConversationController.php">
            <div class="form-group">
                <label for="conversationSubject" id="newConvSubject">Subject: </label>
                <input class="form-control" name="subject" id="conversationSubject" type="text" placeholder="Topic...">
            </div>

            <button class="btn btn-info">Add...</button>
        </form>
    </div>

    <div class="col-md-6">
        <legend>Send message on topic: </legend>
        <hr>
        <form method="post" action="../controllers/MessageController.php">
            <div class="form-group">
                <label for="conversationSubject" id="newConvSubject">Subject: </label>
                <select name="messageSubject" id="conversationSubject" class="form-control">
                    <option value="">Select subject</option>
                    {{options}}
                </select>
            </div>

            <div class="form-group">
                <label for="message" id="convMessage">Message: </label>
                <textarea id="message" class="form-control" name="message"></textarea>
            </div>

            <div class="form-group">
                <button class="btn btn-success">Send</button>
            </div>
        </form>
    </div>
</div>
