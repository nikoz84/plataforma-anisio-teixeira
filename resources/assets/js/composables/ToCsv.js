import { Notify, exportFile } from "quasar"

const wrapCsvValue = (val, formatFn) => {
    let formatted = formatFn !== void 0
        ? formatFn(val)
        : val

    formatted = formatted === void 0 || formatted === null
        ? ''
        : String(formatted)

    formatted = formatted.split('"').join('""')
    /**
     * Excel accepts \n and \r in strings, but some other CSV parsers do not
     * Uncomment the next two lines to escape new lines
     */
    // .split('\n').join('\\n')
    // .split('\r').join('\\r')

    return `"${formatted}"`
}

const exportTable = (data, columns) => {
    // naive encoding to csv format
    console.log(columns)
    if (data === 'undefined') return;

    const content = [columns.map(col => wrapCsvValue(col.label))].concat(
        data.map(row => columns.map(col => wrapCsvValue(
            typeof col.field === 'function'
                ? col.field(row)
                : row[col.field === void 0 ? col.name : col.field],
            col.format
        )).join(','))
    ).join('\r\n')

    const status = exportFile(
        'table-export.csv',
        content,
        'text/csv'
    )

    if (status !== true) {
        Notify({
            message: 'Browser denied file download...',
            color: 'negative',
            icon: 'warning'
        })
    }
}



export {
    exportTable
}