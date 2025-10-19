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
            headerResult.innerHTML = ''; // xóa cũ

            // Users
            if (data.users?.length) {
                const userDiv = document.createElement('div');
                userDiv.classList.add('result-container_user');
                userDiv.innerHTML = `
                    <div class="card-user">
                        <div class="user-title">User</div>
                        ${data.users.map(user => `
                            <div class="user-elem">
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
                articleDiv.innerHTML = `<div class="card-article"><div class="article-title">Article</div>` +
                    data.articles.map(title => `
                        <div class="article-elem">
                            <div id="title-article">${title}</div>
                        </div>
                    `).join('') + `</div>`;
                headerResult.appendChild(articleDiv);
            }

            // News
            if (data.news?.length) {
                const newsDiv = document.createElement('div');
                newsDiv.classList.add('result-container_news');
                newsDiv.innerHTML = `<div class="show-news-card"><div class="news-title">News</div>` +
                    data.news.map(title => `
                        <div class="news-elem">
                            <div id="title-news">${title}</div>
                        </div>
                    `).join('') + `</div>`;
                headerResult.appendChild(newsDiv);
            }

            if (!data.users.length && !data.articles.length && !data.news.length) {
                headerResult.innerHTML = '<div class="result-container">No results</div>';
            }
        })
        .catch(err => console.error(err));
    } else {
        headerResult.style.display = 'none';
    }
});

// Ẩn khi click ngoài
document.addEventListener('click', e => {
    if (!headerResult.contains(e.target) && e.target !== searchInput) {
        headerResult.style.display = 'none';
    }
});
