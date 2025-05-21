class Biblioteca {

    constructor() {

        // enumeraciones para usuario
        const USR_NOMBRE = 0;
        const USR_CORREO = 1;
        const USR_ADMIN = 2;
        const USR_DEUDA_DIAS = 3;
        const USR_PASSWORD = 4;

        // enumeracions para libro
        const LIB_TITULO = 0;
        const LIB_AUTOR = 1;
        const LIB_CATEGORIA = 2;
        const LIB_ESTADO = 3;
        const LIB_FECHA_SALIDA = 4;
        const LIB_USUARIO = 5;

        // enumeraciones para estados
        const EST_LIBRE = 0;
        const EST_SOLICITADO = 1;
        const EST_PRESTADO = 2;
        const ESTADOS = [
            "Libre",
            "Solicitado",
            "Prestado"
        ];

        // enumeracion mensajes
        const MSJ_OK = 0;
        const MSJ_ERR_DESCONOCIDO = -1;
        const MSJ_ERR_CORREO_EXISTENTE = -2;
        const MSJ_ERR_INDICE_INVALIDO = -3;
        const MSJ_ERR_TIENE_MUCHOS_LIBROS = -4;
        const MSJ_ERR_YA_TIENE_ESE_LIBRO = -5;
        const MSJ_ERR_LIBRO_PRESTADO = -6;
        const MSJ_ERR_NO_HA_SIDO_SOLICITADO = -7;
        const MSJ_ERR_NO_HALLADO = -8;
        const MSJ_ERR_NO_HA_SIDO_PRESTADO = -9;
        const MSJ_ERR_NO_PASSWORD = -10;
        const MENSAJES = [
            "Ok",
            "error desconocido",
            "el correo ya está registrado",
            "el índice dado es inválido",
            "el usuario tiene muchos libros",
            "el usuario ya posee el libro",
            "el libro lo tiene otro usuario",
            "no se ha hecho solicitud del libro",
            "no se encontró lo buscado",
            "no se hecho un prestamo del libro",
            "la contraseña es incorrecta"
        ];

        // para organizar los libros
        const CATEGORIAS = [
            "Fantasía", "Historia", "Matemática",
            "Mitología", "Espiritualidad", "Cocina",
            "Ciencia Ficción", "Policial", "Ciencia",
            "Cuento", "Novela", "Filosofía",
            "Computación", "Ingeniería", "Arte",
            "Manga", "Comic", "Infantil",
            "Biografía", "Animales", "Política",
            "Manualidades", "Tutoria", "Arquitectura",
            "Erótico", "Romántico", "Psicología",
            "Medicina", "Plantas", "Geografía",
            "Prehistoria", "Espacio", "Autoayuda",
            "Otra"
        ];

        // constantes del software
        const MAX_PRESTAMOS = 2;
        const MAX_TIEMPO_PRESTADO_DIAS = 14;
        const MAX_TIEMPO_SOLICITADO_DIAS = 3;

        // estructuras de datos
        let libros = [];
        let usuarios = [];
    }

    newUsuario(nombre, correo, password) {
        // devolvera el id >=0 de usuario creado o <0 si error
        for (let u = 0; u < this.usuarios.length; u++) {
            if (this.usuarios[u][this.USR_CORREO] == correo) {
                return this.MSJ_ERR_CORREO_EXISTENTE;
            }
        }
        let usr = [];
        usr[this.USR_NOMBRE] = nombre;
        usr[this.USR_CORREO] = correo;
        usr[this.USR_ADMIN] = false;
        usr[this.USR_DEUDA_DIAS] = 0;
        usr[this.USR_PASSWORD] = password;
        this.usuarios.push(usr);
        return this.usuarios.length - 1;
    }

    newLibro(titulo, autor, id_categoria) {
        // devolvera el id >=0 del libro creado, o <0 si error
        if (id_categoria < 0 || id_categoria >= this.CATEGORIAS.length) {
            return this.MSJ_ERR_INDICE_INVALIDO;
        }
        let lib = [];
        lib[this.LIB_TITULO] = titulo;
        lib[this.LIB_AUTOR] = autor;
        lib[this.LIB_CATEGORIA] = id_categoria;
        lib[this.LIB_ESTADO] = this.EST_LIBRE;
        lib[this.LIB_FECHA_SALIDA] = null;
        lib[this.LIB_USUARIO] = -1;
        this.libros.push(lib);
        return this.libros.length - 1;
    }

    getUsrLibros(usr_id) {
        // devuelve un array con los id de libros que tiene el usuario
        // ya sean prestados o en solicitud
        let libs = [];
        for (let i = 0; i < this.libros.length; i++) {
            if (this.libros[i][this.LIB_USUARIO] == usr_id) {
                libs.push(i);
            }
        }
        return libs;
    }

    getDeuda(usr_id) {
        // devuelve la deuda en dias >=0 incluyendo los viejos prestamos y
        // los en curso, devolvera <0 si error
        if (usr_id < 0 || usr_id >= this.usuarios.length) {
            return this.MSJ_ERR_INDICE_INVALIDO;
        }
        let libs = this.getUsrLibros(usr_id);
        let hoy = new Date();
        let deuda = 0;
        for (let k = 0; k < libs.length; k++) {
            let i = libs[k];
            if (this.libros[i][this.LIB_ESTADO] == this.EST_PRESTADO) {
                let dif = hoy - this.libros[i][this.LIB_FECHA_SALIDA];
                let dias = dif / (1000 * 60 * 60 * 24);
                if (dias > this.MAX_TIEMPO_PRESTADO_DIAS) {
                    deuda += Math.floor(
                        dias - this.MAX_TIEMPO_PRESTADO_DIAS);
                }
            }
        }
        return deuda + this.usuarios[usr_id][this.USR_DEUDA_DIAS];
    }

    freeLibro(libro_id) {
        // libera un libro de prestamo o solicitud, en caso de generar
        // deuda la asocia al usuario, retornara el mismo id >=0 si libero
        // de lo contrario <0 error, no hay que liberar
        if (this.libros[libro_id][this.LIB_ESTADO] == this.EST_PRESTADO) {
            let hoy = new Date();
            let dif = hoy - this.libros[libro_id][this.LIB_FECHA_SALIDA];
            let dias = dif / (1000 * 60 * 60 * 24);
            if (dias > this.MAX_TIEMPO_PRESTADO_DIAS) {
                let usr = this.libros[libro_id][this.LIB_USUARIO];
                this.usuarios[usr][this.USR_DEUDA_DIAS] += Math.floor(
                    dias - this.MAX_TIEMPO_PRESTADO_DIAS);
            }
        }
        if (this.libros[libro_id][this.LIB_ESTADO]) {
            this.libros[libro_id][this.LIB_ESTADO] = this.EST_LIBRE;
            this.libros[libro_id][this.LIB_FECHA_SALIDA] = null;
            this.libros[libro_id][this.LIB_USUARIO] = -1;
            return libro_id;
        }
        return this.MSJ_ERR_NO_HALLADO;
    }

    setPrestamo(usr_id, libro_id) {
        // esto lo llama el usuario, para poner el libro en modo solicitud
        // se establecera la fecha de inicio de la solicitud
        // devuelve >=0 como id de libro afectado, sino <0 error
        if (libro_id < 0 || libro_id >= this.libros.length) {
            return this.MSJ_ERR_INDICE_INVALIDO;
        }
        if (usr_id < 0 || usr_id >= this.usuarios.length) {
            return this.MSJ_ERR_INDICE_INVALIDO;
        }
        let usr_libros = this.getUsrLibros(usr_id);
        if (usr_libros.length >= this.MAX_PRESTAMOS) {
            return this.MSJ_ERR_TIENE_MUCHOS_LIBROS;
        }
        if (usr_libros.includes(libro_id)) {
            return this.MSJ_ERR_YA_TIENE_ESE_LIBRO;
        }
        if (this.libros[libro_id][LIB_ESTADO] != EST_LIBRE) {
            return this.MSJ_ERR_LIBRO_PRESTADO;
        }
        this.libros[libro_id][this.LIB_ESTADO] = this.EST_SOLICITADO;
        this.libros[libro_id][this.LIB_FECHA_SALIDA] = new Date();
        this.libros[libro_id][this.LIB_USUARIO] = usr_id;
        return libro_id;
    }

    setDesprestamo(libro_id) {
        // cuando el usuario se arrepiente de haber hecho una solicitud
        // devuelve el id >=0 del usuario asociado o <0 si error
        if (libro_id < 0 || libro_id >= this.libros.length) {
            return this.MSJ_ERR_INDICE_INVALIDO;
        }
        if (this.libros[libro_id][this.LIB_ESTADO] == this.EST_SOLICITADO) {
            let el_usr = this.libros[libro_id][this.LIB_USUARIO];
            this.freeLibro(libro_id);
            return el_usr;
        }
        return this.MSJ_ERR_NO_HA_SIDO_SOLICITADO;
    }

    setPrestado(libro_id, password) {
        // el administrador llama a esto, pidiendole al usuario que
        // presencialmente ponga su clave, de este modo se le entregara
        // el libro, el contador de fecha se reinicia, devuelve
        // el id >=0 del usuario asociado o <0 si error
        if (libro_id < 0 || libro_id >= this.libros.length) {
            return this.MSJ_ERR_INDICE_INVALIDO;
        }
        if (this.libros[libro_id][this.LIB_ESTADO] == this.EST_SOLICITADO) {
            let usr = this.libros[libro_id][this.LIB_USUARIO];
            if (this.usuarios[usr][this.USR_PASSWORD] == password) {
                this.libros[libro_id][this.LIB_ESTADO] = this.EST_PRESTADO;
                this.libros[libro_id][this.LIB_FECHA_SALIDA] = new Date();
                return usr
            }
            return this.MSJ_ERR_NO_PASSWORD;
        }
        return this.MSJ_ERR_NO_HA_SIDO_SOLICITADO;
    }

    setEntrega(libro_id) {
        // el administrador llama a esto una vez ha recibido un libro
        // devuelve >=0 como id del usuario asociado, o <0 si error
        if (libro_id < 0 || libro_id >= this.libros.length) {
            return this.MSJ_ERR_INDICE_INVALIDO;
        }
        if (this.libros[libro_id][this.LIB_ESTADO] == this.EST_PRESTADO) {
            let el_usr = this.libros[libro_id][this.LIB_USUARIO];
            this.freeLibro(libro_id);
            return el_usr;
        }
        return this.MSJ_ERR_NO_HA_SIDO_PRESTADO;
    }

    getUsrID(correo, password) {
        // permite verificar las credenciales de un usuario, retorna el id
        // que es >=0 o sino <0 en caso de error
        for (let u = 0; u < this.usuarios.length; u++) {
            if (this.usuarios[u][this.USR_CORREO] == correo) {
                if (this.usuarios[u][this.USR_PASSWORD] == password) {
                    return u;
                }
                return this.MSJ_ERR_NO_PASSWORD;
            }
        }
        return this.MSJ_ERR_NO_HALLADO;
    }

    getUsuario(usr_id) {
        // devuelve la informacion array publica del usuario para ser impresa
        // si falla devuelve un array vacio
        if (usr_id < 0 || usr_id >= this.usuarios.length) {
            return [];
        }
        let admin = "Usuario";
        if (this.usuarios[usr_id][this.USR_ADMIN]) {
            admin = "Administrador";
        }
        return [
            this.usuarios[usr_id][this.USR_NOMBRE],
            this.usuarios[usr_id][this.USR_CORREO],
            admin,
            this.getDeuda(usr_id)
        ];
    }

    getLibro(libro_id) {
        // devuelve la informacion array publica del libro para ser impresa
        // si falla devuelve un array vacio
        if (libro_id < 0 || libro_id >= this.libros.length) {
            return [];
        }
        let cat = this.libros[libro_id][this.LIB_CATEGORIA];
        let est = this.libros[libro_id][this.LIB_ESTADO];
        let fecha_salida = "";
        if (est != this.EST_LIBRE) {
            let fs = this.libros[libro_id][this.LIB_FECHA_SALIDA];
            fecha_salida = fs.toDateString();
        }
        return [
            this.libros[libro_id][this.LIB_TITULO],
            this.libros[libro_id][this.LIB_AUTOR],
            this.CATEGORIAS[cat],
            this.ESTADOS[est],
            fecha_salida,
            this.libros[libro_id][this.LIB_USUARIO]
        ];
    }

    passworize(password) {
        // script para crear un sencillo hash, robado de www.geeksforgeeks.org
        // esto se puede usar antes de guardar o comparar claves
        // el string del inicio se pone a gusto, es una mascara extra
        let pass = password + "1234567890";
        return pass.split('').reduce((hash, char) => {
            return char.charCodeAt(0) + (hash << 6) + (hash << 16) - hash;
        }, 0);
    }

    getMsgString(ind_msj) {
        // permite convertir un codigo de error o mensaje en texto
        return this.MENSAJES[abs(ind_msj)];
    }

    watchdogSolicitud() {
        // esto se llamara periodicamente, cada hora, asi se verifica
        // que los libros solicitados se auto liberen
        for (let i = 0; i < this.libros.length; i++) {
            if (this.libros[i][this.LIB_ESTADO] == this.EST_SOLICITADO) {
                let hoy = new Date();
                let dif = hoy - this.libros[i][this.LIB_FECHA_SALIDA];
                let dias = dif / (1000 * 60 * 60 * 24);
                if (dias > this.MAX_TIEMPO_SOLICITADO_DIAS) {
                    this.libros[i][this.LIB_ESTADO] = this.EST_LIBRE;
                    this.libros[i][this.LIB_FECHA_SALIDA] = null;
                    this.libros[i][this.LIB_USUARIO] = -1;
                }
            }
        }
    }
}
