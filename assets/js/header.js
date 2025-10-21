const searchInput = document.querySelector('input[name="search-header"]');
const headerResult = document.querySelector('.header-result');

searchInput.addEventListener('input', () => {
    const val = searchInput.value.trim();

    if (val) {
        fetch('../../service/SearchService.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query: val })
        })
        .then(res => res.json())
        .then(data => {
            headerResult.style.display = 'block';
            headerResult.innerHTML = ''; // Xóa kết quả cũ

            // Users
            if (data.users?.length) {
                const userDiv = document.createElement('div');
                userDiv.classList.add('result-container_user');
                userDiv.innerHTML = `
                    <div class="card-user">
                        <div class="user-title">User</div>
                        ${data.users.map(user => `
                            <div class="user-elem" data-type="user" data-id="${user.id}">
                                <img src="${user.avatar || '#'}" alt="User avatar">
                                <div id="user-name">${user.name}</div>
                            </div>
                        `).join('')}
                    </div>
                `;
                headerResult.appendChild(userDiv);
            }

            // Articles
            if (data.articles?.length) {
                const articleDiv = document.createElement('div');
                articleDiv.classList.add('result-container_article');
                articleDiv.innerHTML = `
                    <div class="card-article">
                        <div class="article-title">Article</div>
                        ${data.articles.map(article => `
                            <div class="article-elem" data-type="article" data-id="${article.id}">
                                <div id="title-article">${article.title}</div>
                            </div>
                        `).join('')}
                    </div>
                `;
                headerResult.appendChild(articleDiv);
            }

            // News
            if (data.news?.length) {
                const newsDiv = document.createElement('div');
                newsDiv.classList.add('result-container_news');
                newsDiv.innerHTML = `
                    <div class="show-news-card">
                        <div class="news-title">News</div>
                        ${data.news.map(news => `
                            <div class="news-elem" data-type="news" data-id="${news.id}">
                                <div id="title-news">${news.title}</div>
                            </div>
                        `).join('')}
                    </div>
                `;
                headerResult.appendChild(newsDiv);
            }

            if ((!data.users || !data.users.length) &&
                (!data.articles || !data.articles.length) &&
                (!data.news || !data.news.length)) {
                headerResult.innerHTML = '<div class="result-container">No results</div>';
            }

            // 👉 Thêm sự kiện click cho tất cả phần tử kết quả
            document.querySelectorAll('.user-elem, .article-elem, .news-elem').forEach(elem => {
                elem.addEventListener('click', () => {
                    const type = elem.dataset.type;
                    const id = elem.dataset.id;

                    let url = '#';
                    if (type === 'user') url = `../profile/profile.php?query=${id}`;
                    else if (type === 'article') url = `/mblogger/views/home/home.php?query-articleID=${id}`;
                    else if (type === 'news') url = `/mblogger/views/news/news.php?query-newsID=${id}`;

                    window.location.href = url;
                });
            });
        })
        .catch(err => console.error(err));
    } else {
        headerResult.style.display = 'none';
    }
});

// Ẩn khi click ra ngoài
document.addEventListener('click', e => {
    if (!headerResult.contains(e.target) && e.target !== searchInput) {
        headerResult.style.display = 'none';
    }
});
