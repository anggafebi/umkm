<h1>Upload Media</h1>

<form method="POST"
action="/admin/media/upload"
enctype="multipart/form-data">

@csrf

<input type="file" name="image">

<button type="submit">
Upload
</button>

</form>