export function updateTable(data, action){
  const tableBody = document.querySelector('table tbody');
  tableBody.innerHTML = '';

  data.forEach(item=>{
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.customer_name || '-'}</td>
      <td>${item.invoice_number || '-'}</td>
      <td>${item.issue_date || '-'}</td>
      <td>${item.due_date || '-'}</td>
      <td>${item.invoice_total || '-'}</td>
    `;
    if(action === 'overpayments'){
      row.innerHTML += `
        <td>${item.overpayment_amount}</td>
        <td>${item.total_paid}</td>
      `;
    }else if(action === 'underpayments'){
      row.innerHTML += `
        <td>${item.underpayment_amount}</td>
        <td>${item.total_paid}</td>
      `;
    }

    tableBody.appendChild(row);
  });
  updateTableHeaders(action);
  const noRecordsMsg = document.getElementsByClassName('no-records-msg')[0];
  const shouldDisplay = data.length === 0;
  
  if (shouldDisplay && noRecordsMsg.style.display !== "flex") {
    noRecordsMsg.style.display = "flex";
  } else if (!shouldDisplay && noRecordsMsg.style.display !== "none") {
    noRecordsMsg.style.display = "none";
  }
}

function updateTableHeaders(action){
  const tableHead = document.querySelector('table thead tr');

  tableHead.innerHTML = `
    <th>Client name</th>
    <th>Invoice number</th>
    <th>Issued at</th>
    <th>Due at</th>
    <th>Full amount</th>
  `;

  if(action === 'overpayments'){
    tableHead.innerHTML += `
      <th>Overpayment amount</th>
      <th>Total paid</th>
    `;
  }else if (action === 'underpayments'){
    tableHead.innerHTML += `
      <th>Underpayment amount</th>
      <th>Total paid</th>
    `;
  }
}