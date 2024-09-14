import { getData } from "./api.js";
import { updateTable } from "./report.js";
import { debounce } from "./utils.js";

document.addEventListener("DOMContentLoaded", async ()=>{
  let currentAction = "overpayments";
  let searchParams = {};

  const initialData = await getData(currentAction, searchParams);
  updateTable(initialData, currentAction);
  
  const buttons = document.querySelectorAll('button[data-action]');
  const filters = document.querySelectorAll('input[data-column]');

  buttons.forEach(button=>{
    button.addEventListener('click', async ()=>{
      filters.forEach(input => input.value = "");
      searchParams = {};
      
      buttons.forEach(btn => btn.classList.remove('nav-active'));
      button.classList.add('nav-active');
      
      currentAction = button.dataset.action;
      const data = await getData(currentAction, searchParams);
      if(data){
        updateTable(data, currentAction);
      }
    })
  })

  const debouncedSearch = debounce(async (column, value)=>{
    searchParams[column] = value;
    const data = await getData(currentAction, searchParams);
    if(data){
      updateTable(data, currentAction);
    }
  }, 300);

  filters.forEach(filter=>{
    filter.addEventListener('input', (e)=>{    
      const column = e.target.dataset.column;
      const value = e.target.value;
      debouncedSearch(column, value);
    })
  })
})