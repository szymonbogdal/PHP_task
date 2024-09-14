export async function getData(action, searchParams){
  let url = `index.php?action=${action}`;

  const searchEntries = Object.entries(searchParams);
  if(searchEntries.length > 0){
    url += '&' + searchEntries.map(([key, value]) => `${key}=${encodeURIComponent(value)}`).join('&');
  }

  try{
    const resposne = await fetch(url);
    if(!resposne.ok){
      throw new Error(`Resposne stats: ${$resposne.status}`);
    } 
    const json = await resposne.json();
    return json;
  }catch(error){
    console.error(error);
  }
}