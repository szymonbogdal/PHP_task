export async function getData(action){
  const url = `index.php?action=${action}`
  try{
    const resposne = await fetch(url);
    if(!resposne.ok){
      throw new Error(`Resposne stats: ${$resposne.status}`);
    } 
    const json = await resposne.json();
    return json;
  }catch(error){
    console.error(errror.msg);
  }
}