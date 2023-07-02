"use strict";

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
          const newsItem = this.createNewsItem(news.title, news.content, news.author, formattedDate);
          this.newsEl.appendChild(newsItem);
        });
      });
  }

  formatDate(dateString) {
    const newsDate = new Date(dateString);
    const formattedDate = newsDate.toISOString().split('T')[0];
    return formattedDate;
  }

  createNewsItem(title, content, author, date) {
    const newsItem = this.template.content.cloneNode(true);

    newsItem.getElementById("news-title").textContent = title;
    newsItem.getElementById("news-content").textContent = content;
    newsItem.getElementById("news-author").textContent = author;
    newsItem.getElementById("news-date").textContent = date;

    return newsItem;
  }
}

// Användning:
const newsManager = new NewsManager("news", "news-template");
newsManager.init();
