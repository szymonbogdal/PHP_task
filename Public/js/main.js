import { getData } from "./api.js";
import { updateTable } from "./report.js";

document.addEventListener("DOMContentLoaded", async ()=>{
  const initialData = await getData("overpayments");
  updateTable(initialData, "overpayments");
  const buttons = document.querySelectorAll('button[data-action]');
  buttons.forEach(button=>{
    button.addEventListener('click', async ()=>{
      buttons.forEach(btn => btn.classList.remove('nav-active'));
      button.classList.add('nav-active');
      
      const action = button.dataset.action;
      const data = await getData(action);
      if (data) {
        updateTable(data, action);
      }
    })
  })
})