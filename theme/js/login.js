 const element = (
     <form role="form" action="/login/" method="POST">
        <fieldset>
          <div className="form-group">
            <input className="form-control" placeholder="E-mail" name="email" type="email" />
          </div>
          <div className="form-group">
            <input className="form-control" placeholder="Password" name="password" type="password" />
          </div>
          <div className="checkbox">
            <label>
              <input name="remember" type="checkbox" defaultValue="Remember Me" />Remember Me
            </label>
          </div>
          {/* Change this to a button or input when using this as a form */}
          <button type="submit" className="btn btn-lg btn-success btn-block">Login</button>
        </fieldset>
      </form>
 );
 
 ReactDOM.render(
  element,
  document.getElementById('form-login')
);