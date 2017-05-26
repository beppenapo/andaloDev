<form id="loginForm" name="loginForm" accept-charset="utf-8">
    <div class="form-group">
        <label for="email" class="control-label">email:</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></span>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="control-label">password:</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
    </div>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" id="loginSubmit">login</button>
</form>
