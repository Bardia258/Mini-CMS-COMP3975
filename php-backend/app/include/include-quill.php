<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

<!-- Create the editor container -->
<form class="container mt-3" action="" method="post">
  <label for="title">Post Title:</label><br>
  <input id="title" name="title" required><br><br>
  <div id="editor" name="content" class="mt-2"></div>
  <input type="submit" class="btn btn-success mt-2" value="Submit">
</form>

<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
  const quill = new Quill('#editor', {
    theme: 'snow'
  });
</script>