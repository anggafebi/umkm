<h1>Login Admin</h1>

<form method="POST" action="/login">
@csrf

<input type="email" name="email" placeholder="Email">

<input type="password" name="password" placeholder="Password">

<button type="submit">
Login
</button>

</form>