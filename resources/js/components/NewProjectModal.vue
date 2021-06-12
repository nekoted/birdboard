<template>
    <modal
        name="new-project-modal"
        classes="p-8 bg-card rounded"
        height="auto"
        width="50%"
        :scrollable="true"
    >
        <h1 class="mb-8 text-center text-2xl">Let's create a project !</h1>
        <form>
            <div class="flex">
                <div class="flex flex-1 flex-col mr-4">
                    <label for="title" class="mb-2 font-bold">Title</label>
                    <input
                        id="title"
                        name="title"
                        v-model="form.title.value"
                        placeholder="Name of your project"
                        class="mb-2 p-2 border  rounded"
                        :class="
                            form.title.errors.length > 0
                                ? 'border-error'
                                : 'border-muted'
                        "
                    />
                    <span
                        class="text-xs italic text-error mb-2"
                        v-for="error in form.title.errors"
                        >{{ error }}</span
                    >
                    <label for="description" class="mb-2 font-bold"
                        >Description</label
                    >
                    <textarea
                        id="description"
                        name="description"
                        v-model="form.description.value"
                        placeholder="Describe your project."
                        class="mb-2 p-2 border rounded"
                        :class="
                            form.description.errors.length > 0
                                ? 'border-error'
                                : 'border-muted'
                        "
                    ></textarea>
                    <span
                        class="text-xs italic text-error mb-2"
                        v-for="error in form.description.errors"
                        >{{ error }}</span
                    >
                </div>

                <div class="flex flex-1 flex-col ml-4">
                    <label class="mb-2 font-bold">Add some tasks</label>

                    <div
                        v-for="(task, index) in form.tasks"
                        class="flex flex-col mb-4"
                    >
                        <div class="flex items-center">
                            <input
                                id="task"
                                name="task"
                                placeholder="Task name ..."
                                class="p-2 border rounded mr-2 flex-1"
                                :class="
                                    task.errors.length > 0
                                        ? 'border-error mb-2'
                                        : 'border-muted'
                                "
                                v-model="task.body"
                            />
                            <button
                                type="button"
                                @click="removeTask(index)"
                                class="text-muted hover:text-accent"
                            >
                                <svg
                                    aria-hidden="true"
                                    focusable="false"
                                    data-prefix="far"
                                    data-icon="trash-alt"
                                    class="svg-inline--fa fa-trash-alt fa-w-14"
                                    role="img"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 448 512"
                                    width="18"
                                    height="18"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                        <span
                            class="text-xs italic text-error"
                            v-for="error in task.errors"
                            >{{ error }}</span
                        >
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center text-xs"
                        @click="addTask"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 18 18"
                            class="mr-2"
                        >
                            <g fill="none" fill-rule="evenodd" opacity=".307">
                                <path
                                    stroke="#000"
                                    stroke-opacity=".012"
                                    stroke-width="0"
                                    d="M-3-3h24v24H-3z"
                                ></path>
                                <path
                                    fill="#000"
                                    d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"
                                ></path>
                            </g>
                        </svg>

                        <span>Add New Task Field</span>
                    </button>
                </div>
            </div>
            <div class="flex justify-end">
                <button class="button" @click.prevent="handleSubmit">
                    Create Project
                </button>
            </div>
        </form>
    </modal>
</template>

<script>
module.exports = {
    data: function() {
        return {
            form: {
                title: { value: "", errors: [] },
                description: { value: "", errors: [] },
                tasks: [{ body: "", errors: [] }]
            }
        };
    },
    methods: {
        getFormDatas: function() {
            let form_datas = {};
            Object.keys(this.form).forEach(field => {
                form_datas[field] = this._data.form[field].value;
                if (field == "tasks") {
                    form_datas[field] = this._data.form[field].map(task => {return {body : task.body}});
                }
            });
            return form_datas;
        },
        handleErrors: function(errors) {
            Object.keys(this.form).forEach(field => {
                if (field == "tasks") {
                    this.form.tasks.forEach((task, index) => {
                        if (errors["tasks." + index + ".body"]) {
                            this.form["tasks"][index].errors = errors[
                                "tasks." + index + ".body"
                            ];
                        }
                    });
                } else {
                    if (errors[field]) {
                        this.form[field].errors = errors[field];
                    }
                }
            });
        },
        handleSubmit: function() {
            axios
                .post("/projects", this.getFormDatas())
                .then(response => {
                    window.location = response.data.message;
                })
                .catch(error => {
                    this.handleErrors(error.response.data.errors);
                });
        },
        addTask: function() {
            this.form.tasks.push({ body: "", errors: [] });
        },
        removeTask: function(index) {
            this.form.tasks = this.form.tasks.filter((item,indexItem) => index != indexItem );
        }
    }
};
</script>

<style scoped>
p {
    font-size: 2em;
    text-align: center;
}
</style>
