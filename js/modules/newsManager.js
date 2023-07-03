class NewsManager {
  constructor(newsElementId, templateId) {
    this.newsEl = document.getElementById(newsElementId);
    this.template = document.getElementById(templateId);
  }
  init() {
    this.getNews();
  }
  getNews() {
    fetch('https://tildakallstrom.se/newsapi/news.php')
      .then(response => response.json())
      .then(data => {
        data.forEach(news => {
          const formattedDate = this.formatDate(news.date);
          const newsItem = this.createNewsItem(news.title, news.content, news.author, formattedDate, news.image);
          this.newsEl.appendChild(newsItem);

          const readMoreButton = newsItem.querySelector('.read-more-button');
          readMoreButton.addEventListener('click', () => {
            window.location.href = 'nyheter/artikel.html?id=' + news.id;
          });
        });
      });
  }

  formatDate(dateString) {
    const newsDate = new Date(dateString);
    const formattedDate = newsDate.toLocaleDateString('sv-SE');
    return formattedDate;
  }

  createNewsItem(title, content, author, date, imageUrl) {
    const newsItem = document.createElement('article');
    newsItem.classList.add('news-article');
  
    const titleEl = document.createElement('h3');
    titleEl.textContent = title;
    titleEl.classList.add('news-title');
    newsItem.appendChild(titleEl);

    const authorEl = document.createElement('span');
    authorEl.textContent = author;
    authorEl.classList.add('news-author');
    newsItem.appendChild(authorEl);
  
    const dateEl = document.createElement('span');
    dateEl.textContent = date;
    dateEl.classList.add('news-date');
    newsItem.appendChild(dateEl);

    const imageEl = document.createElement('img');
    imageEl.src = imageUrl;
    imageEl.classList.add('news-image');
    newsItem.appendChild(imageEl);
  
    const contentEl = document.createElement('p');
    const words = content.split(' ');
    const limitedContent = words.slice(0, 20).join(' ');
    contentEl.textContent = limitedContent + '...';
    contentEl.classList.add('news-content');
    newsItem.appendChild(contentEl);
  
    const readMoreButton = document.createElement('button');
    readMoreButton.textContent = 'Läs mer';
    readMoreButton.classList.add('read-more-button');
    newsItem.appendChild(readMoreButton);
  
    return newsItem;
  }
}
export default NewsManager;