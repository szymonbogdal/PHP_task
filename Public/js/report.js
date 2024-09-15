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
      <td>${formatCurrency(item.invoice_total) || '-'}</td>
    `;
    if(action === 'overpayments'){
      row.innerHTML += `
        <td>${formatCurrency(item.overpayment_amount)}</td>
        <td>${formatCurrency(item.total_paid)}</td>
      `;
    }else if(action === 'underpayments'){
      row.innerHTML += `
        <td>${formatCurrency(item.underpayment_amount)}</td>
        <td>${formatCurrency(item.total_paid)}</td>
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
    <th data-sort="customer_name">Client name &#8597;</th>
    <th data-sort="invoice_number">Invoice number &#8597;</th>
    <th data-sort="issue_date">Issue date &#8597;</th>
    <th data-sort="due_date">Due date &#8597;</th>
    <th data-sort="invoice_total">Full amount &#8597;</th>
  `;

  if(action === 'overpayments'){
    tableHead.innerHTML += `
      <th data-sort="overpayment_amount">Overpayment amount &#8597;</th>
      <th data-sort="total_paid">Total paid &#8597;</th>
    `;
  }else if (action === 'underpayments'){
    tableHead.innerHTML += `
      <th data-sort="underpayment_amount">Underpayment amount &#8597;</th>
      <th data-sort="total_paid">Total paid &#8597;</th>
    `;
  }
}

function formatCurrency(amount, locale = 'en-US', currency = 'USD') {
  return new Intl.NumberFormat(locale, {
    style: 'currency',
    currency: currency,
  }).format(amount);
}