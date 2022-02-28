function simpleDate(date) {
    const d = new Date(date);

    const day = d.getDate().toString().padStart(2, '0')
    const month = (d.getMonth()+1).toString().padStart(2, '0')
    const year = d.getFullYear().toString().padStart(2, '0')

    const hours = d.getHours().toString().padStart(2, '0');
    const minutes = d.getMinutes().toString().padStart(2, '0');

    return `${day}/${month}/${year} à ${hours}:${minutes}`;
}