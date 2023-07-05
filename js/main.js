import NewsManager from './modules/newsManager.js';
import ArticleManager from './modules/articleManager.js';
import MenuManager from './modules/menuManager.js';

const newsElementId = "news";
const templateId = "news-template";

const menuElementId = "menu";
const menuTemplateId = "menu-template";

// Kolla om nyhetsdelen av sidan finns
const newsElement = document.getElementById(newsElementId);
if (newsElement) {
  const newsManager = new NewsManager(newsElementId, templateId);
  newsManager.init();

  // Skapa en instans av ArticleManager och initiera den
  const articleManager = new ArticleManager("article", "article-template");
  articleManager.init();
}

// Kolla om menydelen av sidan finns
const menuElement = document.getElementById(menuElementId);
if (menuElement) {
  const menuManager = new MenuManager(menuElementId, menuTemplateId);
  menuManager.init();
}
