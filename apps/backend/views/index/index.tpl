<div class="container">
    <div class="signin-row row">
        <div class="span4"></div>
        <div class="span8">
            <div class="container-signin">
                {{ flash.output() }}
                <legend>Please Login</legend>
                {{ form('/admin/index', 'method': 'post', 'class': 'form-signin') }}
                <div class="form-inner">
                    <div class="input-prepend">

                        <span class="add-on" rel="tooltip" title="Username or E-Mail Address" data-placement="top"><i
                                    class="icon-envelope"></i></span>
                        <input type="text" class="span4" id="username" name="username" />
                    </div>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-key"></i></span>
                        <input type="password" class="span4" id="password" name="password" />
                    </div>
                    <label class="checkbox" for="remember_me">Remember me
                        <input type="checkbox" id="remember_me" name="remember_me" />
                    </label>
                </div>
                <footer class="signin-actions">
                    <input class="btn btn-primary" type="submit" id="submit" value="Login">
                </footer>
                {{ end_form() }}
            </div>
        </div>
        <div class="span3"></div>
    </div>
</div>