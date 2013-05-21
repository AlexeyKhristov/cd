<!DOCTYPE html>
<html>
  <head>
    <title>simple continuous delivery system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body>
      <? if (!empty($output)) : ?>
        <pre>
          <?=$output?>
        </pre>
      <? endif; ?>

      <div class="container">
        <h1>Current branch: <?=$flow->getCurrentBranch()?></h1>
        <form action="/" method="post">
          <input type="hidden" name="action" value="changeBranch">
          <select name="branch" style="margin-top:10px;">
            <? foreach($flow->getBranches() as $branch): ?>
              <option value="<?=$branch?>"><?=$branch?></option>
            <? endforeach; ?>
          </select>
          <input class="btn btn-primary" type="submit" value="Change branch">
        </form>
        <hr>
        <form action="/" method="post">
          <input type="hidden" name="action" value="gitPull">
          <input class="btn btn-primary" type="submit" value="Pull current branch (git pull)">
        </form>
        <br>
        <form action="/" method="post">
          <input type="hidden" name="action" value="clearCache">
          <input class="btn btn-primary" type="submit" value="Clear cache for current branch (rm core/cache*)">
        </form>
      </div>

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>