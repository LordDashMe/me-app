function numberFomatter(number, format) {
    switch (format) {
        case 'k':
            return Math.abs(number) > 999 ? (Math.sign(number) * ((Math.abs(number)/1000).toFixed(1)) + 'k') : (Math.sign(number) * Math.abs(number));
        case 'comma':
        default:
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }   
}
