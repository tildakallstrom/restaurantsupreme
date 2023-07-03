class MenuManager {
    constructor(menuElementId, menuTemplateId) {
      this.menuEl = document.getElementById(menuElementId);
      this.menuTemplate = document.getElementById(menuTemplateId);
    }
    init() {
      this.getMenu();
    }
    getMenu() {
      fetch('https://tildakallstrom.se/APImenu/menu.php')
        .then(response => response.json())
        .then(data => {
          const menuByType = this.groupMenuByType(data);
          this.displayMenu(menuByType);
        });
    }
    groupMenuByType(data) {
      const groupedMenu = {};
      data.forEach(menu => {
        const { type } = menu;
        if (groupedMenu[type]) {
          groupedMenu[type].push(menu);
        } else {
          groupedMenu[type] = [menu];
        }
      });
      return groupedMenu;
    }
    displayMenu(menuByType) {
      for (const type in menuByType) {
        const menuItems = menuByType[type];
        this.createMenuSection(type, menuItems);
      }
    }
    createMenuSection(type, menuItems) {
      const section = document.createElement('section');
      section.classList.add('menu-section');
  
      const heading = document.createElement('h2');
      heading.textContent = type;
      section.appendChild(heading);
  
      menuItems.forEach(menu => {
        const menuItem = this.createMenuItem(menu);
        section.appendChild(menuItem);
      });
  
      this.menuEl.appendChild(section);
    }
    createMenuItem(menu) {
      const menuItem = document.createElement('article');
      menuItem.classList.add('menu-item');
  
      const descriptionEl = document.createElement('p');
      descriptionEl.classList.add('description');
      descriptionEl.textContent = menu.description;
      menuItem.appendChild(descriptionEl);
  
      return menuItem;
    }
  }
  export default MenuManager;  