options=--inputOptions="-i turtle"
OWCLIDATA=owcli -w aksw.org -m http://aksw.org/ ${options}
OWCLISCHEMA=owcli -w aksw.org -m http://aksw.org/ ${options}
OWCLICONFIG=owcli -w aksw.org -m http://localhost/OntoWiki/Config/ ${options}

default:
	@echo "no default target"

install: clean create install-people install-projects install-groups install-pages install-schema

clean:
	${OWCLIDATA} -e model:drop

create:
	${OWCLIDATA} -e model:create
	${OWCLICONFIG} -e model:add -i config.n3

install-projects:
	${OWCLIDATA} -e model:add -i FundedProjects.n3 
	${OWCLIDATA} -e model:add -i OpenSourceProjects.n3
	${OWCLIDATA} -e model:add -i AlumniProjects.n3
	${OWCLIDATA} -e model:add -i IncubatorProjects.n3

install-pages:
	${OWCLIDATA} -e model:add -i Pages.n3
	${OWCLIDATA} -e model:add -i aksworg.n3

install-groups:
	${OWCLIDATA} -e model:add -i Groups.n3

install-schema:
	${OWCLISCHEMA} -e model:add -i schema.n3

install-people:
	${OWCLIDATA} -e model:add -i People.n3
