export function useStatusMetodeBayar() {
    const formatStatusMetodeBayar = (status) => {
        switch(status) {
            case 'CASH':
                return {
                    icon: '💵',
                    text: 'Tunai',
                    class: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'CREDIT_CARD':
                return {
                    icon: '💳',
                    text: 'Kartu Kredit',
                    class: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'DEBIT_CARD':
                return {
                    icon: '💳',
                    text: 'Kartu Debit',
                    class: 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'TRANSFER':
                return {
                    icon: '🏦',
                    text: 'Transfer Bank',
                    class: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            case 'EWALLET':
                return {
                    icon: '📱',
                    text: 'E-Wallet',
                    class: 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-300 rounded-full px-3 py-1 text-sm font-medium'
                };
            default:
                return {
                    icon: '❓',
                    text: 'Lainnya',
                    class: 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 rounded-full px-3 py-1 text-sm font-medium'
                };
        }
    };

    return {
        formatStatusMetodeBayar
    };
}