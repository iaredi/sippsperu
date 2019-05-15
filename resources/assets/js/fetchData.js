export default async function fetchData(url, body) {
    let myapi = `https://biodiversidadpuebla.online/api/${url}`;
    if (window.location.host != "biodiversidadpuebla.online")
        myapi = `http://${window.location.host}/api/${url}`;
    const rawResponse = await fetch(myapi, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json;",
            mode: "cors"
        },
        body: JSON.stringify(body)
    });
    let dataResult = await rawResponse.json();
    return dataResult;
}
