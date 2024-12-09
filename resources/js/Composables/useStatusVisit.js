export function useStatusVisit() {
    const formatStatusType = (status) => {
        switch(status) {
            case true:
            case 1:
            case 'true':
            case 'ACTIVE':
                return {
                    icon: '✓',
                    text: 'Aktif',
                    class: 'text-green-600 dark:text-green-400 dark:bg-dark-default rounded-md px-2 py-1'
                };
            case 'FROZEN':
                return {
                    icon: '❄️',
                    text: 'Beku',
                    class: 'text-blue-600 dark:text-blue-400 dark:bg-dark-default rounded-md px-2 py-1'
                };
            case 'CANCELLED':
                return {
                    icon: '✗',
                    text: 'Dibatalkan',
                    class: 'text-gray-600 dark:text-gray-400 dark:bg-dark-default rounded-md px-2 py-1'
                };
            case 'EXPIRED':
                return {
                    icon: '⏰',
                    text: 'Kedaluarsa',
                    class: 'text-orange-600 dark:text-orange-400 dark:bg-dark-default rounded-md px-2 py-1'
                };
            default:
                return {
                    icon: '✗',
                    text: 'Tidak Aktif',
                    class: 'text-red-600 dark:text-red-400 dark:bg-dark-default rounded-md px-2 py-1'
                };
        }
    };

    const formatStatusVisit = (status) => {
        if (status === true || status === 1 || status === 'true') {
            return {
                icon: '✓',
                text: 'Selesai',
                class: 'text-green-600 dark:text-green-400 dark:bg-dark-default rounded-md px-2 py-1'
            };
        }
        return {
            icon: '✗',
            text: 'Belum Selesai',
            class: 'text-red-600 dark:text-red-400 dark:bg-dark-default rounded-md px-2 py-1'
        };
    };

    return {
        formatStatusType,
        formatStatusVisit
    };
}