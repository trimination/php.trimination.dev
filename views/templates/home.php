<div class="home-container">
    <div class="welcome">
        <?php
        $subdomainDescribe = "This particular area of trimination.dev is written using PHP to demonstrate my understanding of the language, although I'm pretty sure I spent more time on the front-end than I did writing the PHP here!";

        if (count($post) > 0) {
            $post = $post[0];
            echo '<h1>' . $post->title . '</h1>' . PHP_EOL;
            echo str_replace('{{subdomain-describe}}', $subdomainDescribe, $post->content);
        }
        ?>
    </div>
    <div class="home-image">
        <img src="<?= BASE_URL ?>/assets/sylvanas.gif" alt="Sylvanas animated GIF" id="sylvanas"/>
    </div>
</div>
<div id="tech-stack">
    <div>
        <h1>Tech Stack</h1>
        <p>These are all the technologies that I am either currently using or am comfortable using</p>
        <?php
        $path = BASE_DIR . '/assets/logos/';
        $dirs = glob($path . '/*', GLOB_ONLYDIR);
        rsort($dirs);
        foreach ($dirs as $dir) {
            $dirName = str_replace($path . '/', '', $dir);
            $currentDir = $path . $dirName;
            $images = glob($currentDir . "/*.png");
            ?>
            <h2><?= \trimination\Helper::ucfirst($dirName); ?> Technologies</h2>
            <div class="tech-stack-wrapper">
                <?php
                for ($i = 0; $i < count($images); $i += 2) {
                    $imgA = str_replace($currentDir . '/', '', $images[$i]);
                    ?>
                    <div class="tech-stack-card">
                        <div class="content">
                            <div class="front toggleable">
                                <img src="<?= BASE_URL ?>/assets/logos/<?= $dirName . '/' . $imgA ?>"
                                     class="tech-stack-image"
                                     loading="lazy"/>
                            </div>
                            <div class="back toggleable">
                                <?php
                                $friendlyImg = explode('-', str_replace('.png', '', $imgA));
                                $friendlyImg[0] = strtoupper($friendlyImg[0]);
                                echo '<span class="tech-stack-card-text">' . $friendlyImg[0] . '</span>' . PHP_EOL;
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
            </div>
            <br/>
            <br/>
            <?php
        }
        ?>
    </div>
</div>