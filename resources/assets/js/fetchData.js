export default async function fetchData(url, body) {
    let myapi = `https://biodiversidadpuebla.online/api/${url}`;
    if (window.location.host == "localhost:3000" || "10.53.1.217:8080")
        myapi = `http://localhost:3000/api/${url}`;
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
