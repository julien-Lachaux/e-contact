const contacts = {

    /**
     * @description ouvre la modal de detail d'contact
     */
    detailsContactModal(contactId) {
        let modals = $("#modals")
        app.get("/contacts/details/" + contactId, (reponse) => {
            modals.html(reponse)
            adresses.contactAdressesListe("#contactAdresses", contactId)
            $("#modalContact").modal("show")
        })
    },

    /**
     * @description ouvre la modal de creation de contact
     */
    nouveauContactModal() {
        let modals = $("#modals")
        app.get("/contacts/formulaire", (reponse) => {
            modals.html(reponse)
            $("#modalContact").modal("show")
        })
    },

    /**
     * @description ajout un nouveau contact
     */
    nouveauContact() {
        let modals = $("#modals")
        let modal = $("#modalContact")
        app.ajaxForm("#formContact", (reponse) => {
            modal.remove()
            $(".modal-backdrop").remove()
            modals.html(reponse)
            modal = $("#modalContact")
            modal.modal("show")
        })
    },

    /**
     * @description renvois au contact de l'utilisateur apres la creation d'un contact
     */
    nouveauContactCreer() {
        app.get("/utilisateur/contacts", (reponse) => {
            $(".contenu").html(reponse)
        })
    },

    /**
     * @description ouvre la modal d'edition d'un contact
     * @param {integer} contactId 
     */
    editerContactModal(contactId) {
        let modals = $("#modals")
        app.get("/contacts/formulaire/" + contactId, (reponse) => {
            let modal = $("#modalContact")
            modal.remove()
            $(".modal-backdrop").remove()
            modals.html(reponse)
            adresses.contactAdressesListe("#contactAdresses", contactId)
            $("#modalContact").modal("show")
        })
    },

    /**
     * @description edite le contact
     */
    editerContact() {
        let modals = $("#modals")
        let modal = $("#modalContact")
        app.ajaxForm("#formContact", (reponse) => {
            modal.remove()
            $(".modal-backdrop").remove()
            modals.html(reponse)
            modal = $("#modalContact")
            modal.modal("show")
        })
    },

    /**
     * @description supprime le contact
     * @param {integer} contactId 
     */
    supprimerContact(contactId) {
        app.get("/contacts/supprimer/" + contactId, (reponse) => {

            app.get("/utilisateur/contacts", (sousReponse) => {
                let modal = $("#modalContact")
                modal.remove()
                $(".modal-backdrop").remove()
                $(".contenu").html(sousReponse)
                $("#alertes").html(reponse)
                setTimeout(() => {
                    $("#alerteContact").alert("close")
                    setTimeout(() => {
                        $("#alerteContact").remove()
                    }, 2000);
                }, 5000);
            })
        })
    },

    /**
     * @description valide l'email du contact
     */
    validerEmail() {
        let contactEmailInput = $("#contact-email");
        let emailValidateurBtn = $("#email-validateur");
        let emailAValider = contactEmailInput.val();
        app.post("/validateurs/email", { email: emailAValider }, (reponse) => {
            if (reponse.erreur === undefined) {
                if (reponse.emailValide) {
                    contactEmailInput.addClass("is-valid")
                    emailValidateurBtn.removeClass("btn-outline-dark")
                    emailValidateurBtn.addClass("btn-outline-success")
                } else {
                    contactEmailInput.addClass("is-invalid")
                    emailValidateurBtn.removeClass("btn-outline-dark")
                    emailValidateurBtn.addClass("btn-outline-danger")
                }
            } else {
                console.log(reponse.erreur);
                contactEmailInput.addClass("is-invalid")
            }
        })
    }

}