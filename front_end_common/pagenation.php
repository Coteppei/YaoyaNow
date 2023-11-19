<div class="all-pagination">
    <?php if ($currentPage > 1): ?>
        <a href="?<?php if(isset($html_searchKeyword)){echo $html_searchKeyword;}?>page=<?php echo $currentPage - 1; ?>" class="PC-display mr-4">≪前のページへ</a>
        <a href="?<?php if(isset($html_searchKeyword)){echo $html_searchKeyword;}?>page=<?php echo $currentPage - 1; ?>" class="SP-display mr-4">≪前へ</a>
    <?php endif; ?>
    <div class="pagination">
        <?php for ($page = 1; $page <= $total_page; $page++): ?>
            <?php if ($page == $currentPage): ?>
                <p><?php echo $page; ?></p>
            <?php else: ?>
                <a href="?<?php if(isset($html_searchKeyword)){echo $html_searchKeyword;}?>page=<?php echo $page; ?>"><?php echo $page; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
    <?php if ($currentPage < $total_page): ?>
        <a href="?<?php if(isset($html_searchKeyword)){echo $html_searchKeyword;}?>page=<?php echo $currentPage + 1; ?>" class="PC-display ml-4">次のページへ≫</a>
        <a href="?<?php if(isset($html_searchKeyword)){echo $html_searchKeyword;}?>page=<?php echo $currentPage + 1; ?>" class="SP-display ml-4">次へ≫</a>
    <?php endif; ?>
</div>
