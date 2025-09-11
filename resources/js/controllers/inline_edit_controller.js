import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
  static targets = ["editRow"]

  connect() {
    // Store bound function references for proper event listener cleanup
    this.boundHandleFrameLoad = this.handleFrameLoad.bind(this)
    this.boundHandleBeforeResponse = this.handleBeforeResponse.bind(this)

    // Listen for turbo:frame-load events to show edit rows when forms are loaded
    document.addEventListener("turbo:frame-load", this.boundHandleFrameLoad)

    // Listen for turbo:before-fetch-response to handle form submissions
    document.addEventListener("turbo:before-fetch-response", this.boundHandleBeforeResponse)
  }

  disconnect() {
    document.removeEventListener("turbo:frame-load", this.boundHandleFrameLoad)
    document.removeEventListener("turbo:before-fetch-response", this.boundHandleBeforeResponse)
  }

  handleFrameLoad(event) {
    const frame = event.target

    // If an edit form is loaded, show the edit row
    if (frame.id.includes("edit-form")) {
      const editRowId = frame.id.replace("edit-form", "edit-row")
      const editRow = document.getElementById(editRowId)
      if (editRow) {
        editRow.classList.remove("hidden")
      }
    }
  }

  handleBeforeResponse(event) {
    const response = event.detail.fetchResponse.response

    // If form submission was successful (redirect), hide edit rows
    if (response.redirected) {
      this.hideAllEditRows()
    }
  }

  hideAllEditRows() {
    document.querySelectorAll('[id*="edit-row"]').forEach(row => {
      row.classList.add("hidden")
    })
  }

  hideEditRow(event) {
    const editRow = event.currentTarget.closest('tr')
    if (editRow) {
      editRow.classList.add("hidden")
    }
  }
}