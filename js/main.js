import NewsManager from './modules/newsManager.js';
import ArticleManager from './modules/articleManager.js';

const newsElementId = "news";
const templateId = "news-template";

const newsManager = new NewsManager(newsElementId, templateId);
newsManager.init();

// Skapa en instans av ArticleManager och initiera den
const articleManager = new ArticleManager("article", "article-template");
articleManager.init();
