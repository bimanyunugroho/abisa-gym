export const useRupiah = () => {
    const formatRupiah = (angka) => {
        const number = Number(angka);
        if (isNaN(number)) return '';
        return number.toLocaleString('id-ID');
    };

    const parseRupiah = (rupiahString) => {
        return parseFloat(rupiahString.replace(/\./g, ''));
    };

    return { 
        formatRupiah, 
        parseRupiah 
    };
};