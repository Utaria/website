<div class="top-box">
  <div class="row-container">
    <div class="left">
      <h1>Blog de développement</h1>
      <h3 class="subtitle">Retrouvez les nouveautés d'UTARIA</h3>
    </div>
  </div>
</div>
<div class="content row-container">
    <?php if (empty($d->articles)): ?>
      <p class="nothinghere">Aucun article dans le blog !</p>
    <?php endif; ?>

    <?php function printArticle($article)
    { ?>
      <div class="article">
        <div class="date"><?= strftime("%d %B %Y", strtotime($article->date)) ?></div>
        <a href="/devblog/<?= slugify($article->title) ?>" title="<?= $article->title; ?>">
          <div class="title"><?= $article->title; ?></div>
        </a>
        <div class="server"><?= ucfirst($article->name); ?></div>
      </div>
    <?php } ?>

    <?php if (!empty($d->articles)): ?>
      <div class="row-3">
          <?php foreach ($d->articles as $i => $art):
              if ($i % 3 != 0) continue;
              printArticle($art);
          endforeach; ?>
      </div>
      <div class="row-3">
          <?php foreach ($d->articles as $i => $art):
              if ($i % 3 != 1) continue;
              printArticle($art);
          endforeach; ?>
      </div>
      <div class="row-3">
          <?php foreach ($d->articles as $i => $art):
              if ($i % 3 != 2) continue;
              printArticle($art);
          endforeach; ?>
      </div>
    <?php endif; ?>

  <div class="clear"></div>
</div>
