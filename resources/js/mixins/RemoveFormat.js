export const PasteCapture = {
    
    methods: {

        pasteCapture (evt) {
            let text, onPasteStripFormattingIEPaste
            evt.preventDefault()
            if (evt.originalEvent && evt.originalEvent.clipboardData.getData) {
              text = evt.originalEvent.clipboardData.getData('text/plain')
              this.$refs.editor_ref.runCmd('insertText', text)
            }
            else if (evt.clipboardData && evt.clipboardData.getData) {
              text = evt.clipboardData.getData('text/plain')
              this.$refs.editor_ref.runCmd('insertText', text)
            }
            else if (window.clipboardData && window.clipboardData.getData) {
              if (!onPasteStripFormattingIEPaste) {
                onPasteStripFormattingIEPaste = true
                this.$refs.editor_ref.runCmd('ms-pasteTextOnly', text)
              }
              onPasteStripFormattingIEPaste = false
            }
          }

    },
    
};