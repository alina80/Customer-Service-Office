<tr>
    <td>{{conversationSubject}}</td>
    <td>
        <form method="post" action="../controllers/ConversationController.php">
            <div class="form-group" style="display: none">
                <label for="conversationSubject">Subject: </label>
                <input class="form-control" name="subject" id="conversationSubject" type="text" value="{{conversationSubject}}" contenteditable="false">
            </div>

            <div class="form-group" style="display: none">
                <label for="conversationId">Conversation Id: </label>
                <input class="form-control" name="id" id="conversationId" type="number" value="{{conversationId}}" contenteditable="false">
            </div>

            <div class="form-group" style="display: none">
                <label for="clientId" id="newConvSubject">Client Id: </label>
                <input class="form-control" name="client_id" id="clientId" type="number" value="{{clientId}}" contenteditable="false">
            </div>

            <button class="btn btn-xs btn-primary">Assign</button></td>
        </form>

</tr>
