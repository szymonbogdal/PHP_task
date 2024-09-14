import { getData } from "./api.js";
import { updateTable } from "./report.js";
import { debounce } from "./utils.js";

document.addEventListener("DOMContentLoaded", async ()=>{
  let currentAction = "overpayments";
  let searchParams = {};
  let sortParams = {sort_by: "issue_date", order_by: "ASC"};
  
  const buttons = document.querySelectorAll('button[data-action]');
  const filters = document.querySelectorAll('input[data-column]');

  async function callApi(){
    const data = await getData(currentAction, searchParams, sortParams);
    const errorMsg =  document.getElementsByClassName('error-msg')[0];
    if(data.error){
      console.error(data.error);
      errorMsg.style.display = "flex";      
    }else{
      if(errorMsg.style.display == "flex"){
        errorMsg.style.display = "none"
      }
      updateTable(data, currentAction, sortParams);
      createTableHeadertListener();
    }
  }
  
  function createTableHeadertListener(){
    const tableHeaders = document.querySelectorAll('th[data-sort]');
    tableHeaders.forEach(th=>{
      th.addEventListener('click', async (e)=>{
        if(e.target.dataset.sort === sortParams.sort_by){
          sortParams.order_by = sortParams.order_by === 'ASC' ? 'DESC':'ASC';
        }else{
          sortParams.sort_by = e.target.dataset.sort;
          sortParams.order_by = "ASC";
        }
        callApi();
      })
    })
  }

  callApi();

  buttons.forEach(button=>{
    button.addEventListener('click', async ()=>{
      filters.forEach(input => input.value = "");
      searchParams = {};
      
      buttons.forEach(btn => btn.classList.remove('nav-active'));
      button.classList.add('nav-active');
      
      currentAction = button.dataset.action;
      sortParams = {sort_by: "issue_date", order_by: "ASC"};
      const data = await getData(currentAction, searchParams, sortParams);
      callApi();
    })
  })

  const debouncedSearch = debounce(async (column, value)=>{
    searchParams[column] = value;
    sortParams = {sort_by: "issue_date", order_by: "ASC"};
    const data = await getData(currentAction, searchParams, sortParams);
    callApi();
  }, 300);

  filters.forEach(filter=>{
    filter.addEventListener('input', (e)=>{    
      const column = e.target.dataset.column;
      const value = e.target.value;
      debouncedSearch(column, value);
    })
  })
})