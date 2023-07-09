// here is where some npm packages imported such as axios
// and you don't have to import them again
import './bootstrap';

import Search from './live-search';

// if the page has a search icon
if(document.querySelector(".header-search-icon")){
    new Search();
}
