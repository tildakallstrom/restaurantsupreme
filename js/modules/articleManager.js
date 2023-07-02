class ArticleManager {
    constructor(newsElementId, templateId) {
      this.newsEl = document.getElementById(newsElementId);
      this.template = document.getElementById(templateId);
    }
  
    init() {
      const articleId = this.getArticleIdFromURL();
      if (articleId) {
        this.getArticleById(articleId);
      }
    }
  
    getArticleIdFromURL() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('id');
    }
  
    getArticleById(id) {
      fetch('https://tildakallstrom.se/newsapi/news.php')
        .then(response => response.json())
        .then(data => {
          const selectedArticle = data.find(news => news.id === id);
  
          if (selectedArticle) {
            const formattedDate = this.formatDate(selectedArticle.date);
            const newsItem = this.createNewsItem(selectedArticle.title, selectedArticle.content, selectedArticle.author, formattedDate);
            this.newsEl.appendChild(newsItem);
          }
        });
    }
  
    formatDate(dateString) {
      const newsDate = new Date(dateString);
      const formattedDate = newsDate.toISOString().split('T')[0];
      return formattedDate;
    }
  
    createNewsItem(title, content, author, date) {
      const articleContainer = document.createElement('article');
      articleContainer.classList.add('news-article');
  
      const articleTitle = document.createElement('h3');
      articleTitle.textContent = title;
      articleContainer.appendChild(articleTitle);
  
      const articleContent = document.createElement('p');
      articleContent.textContent = content;
      articleContainer.appendChild(articleContent);
  
      const articleAuthor = document.createElement('span');
      articleAuthor.textContent = author;
      articleContainer.appendChild(articleAuthor);
  
      const articleDate = document.createElement('span');
      articleDate.textContent = date;
      articleContainer.appendChild(articleDate);
  
      return articleContainer;
    }
  }
  
  export default ArticleManager;
  