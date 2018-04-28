#pragma once

#include <string>
#include <iostream>
#include <list>
#include "result.h"
#include <fstream>
#include <sstream>
#include <stdio.h>


int st(std::string &s) {
	std::stringstream S;
	S << s;
	int h, m, ss;
	std::string H, M, SS;
	getline(S, H, ':');
	getline(S, M, ':');
	getline(S, SS, ',');
	h = std::stoi(H);
	m = std::stoi(M);
	ss = std::stoi(SS);
	return (h * 60 * 60 + m * 60 + ss);
}

bool checkandupdate(std::list<Result>::iterator & it, Result &r) {
	bool changed = false;
	if ((*it).finish != r.finish) { (*it).finish = r.finish; changed = true; }
	if ((*it).start != r.start) { (*it).start = r.start; changed = true; }
	if ((*it).time != r.time) { (*it).time = r.time; changed = true; }
	if ((*it).status != r.status) { (*it).status = r.status; changed = true; }
	for (int i = 0; i < 64; i++) {
		if ((*it).check[i] != r.check[i]) { (*it).check[i] = r.check[i]; changed = true; }
		if ((*it).checknr[i] != r.checknr[i]) { (*it).checknr[i] = r.checknr[i]; changed = true; }
	}
	return changed;
}

void read(std::string &name, std::list<Result> & l, unsigned char type) {
	try {
		//átnevez
		int resultsss = rename(name.c_str(), "eredmeny.csv");
		if (resultsss != 0) {
			if (remove("eredmeny.csv") != 0)
				std::cout << "Error deleting file";
			else
				std::cout << "File successfully deleted";
			std::cout << "fos";
			return;
		}
		std::cout << "nemfos";
		std::ifstream file("eredmeny.csv");
		file.ignore(std::numeric_limits<std::streamsize>::max(),'\n');
		std::list<Result>::iterator it = l.begin();
		int f= 2;
		for (;;) {
			//std::cout << std::endl << f++;
			if (file.eof() || file.bad() ||file.peek()==EOF)
				break;
			
			for (int i = 0; i < 5; i++) 
				file.ignore(std::numeric_limits<std::streamsize>::max(),';');

			Result r;
			getline(file, r.lastname, ';');
			getline(file, r.firstname, ';');

			for (int i = 0; i < 4; i++)
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');

			if (r.lastname == "Marczis")
				std::cout << "x";

			std::string time;
			getline(file, time, ';'); //start
			r.start = time != "" ? st(time) : 0;
			getline(file, time, ';'); //finish
			r.finish = time!=""?st(time):0;
			getline(file, time, ';'); //time
			r.time = time != "" ? st(time) : 0;

			getline(file, time, ';'); //classifier
			r.status = (char)stoi(time);

			//std::cout << posnc;

			for (int i = 0; i < 4; i++)
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');

			std::string cl1, cl2;
			getline(file, cl1, ';');
			getline(file, cl2, ';');
			r.club = (cl1 != "")? cl1 +" "+ cl2:cl2;

			for (int i = 0; i < 4; i++)
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');

			getline(file, r.category, ';');

			if (type == 1) {
				for (int i = 0; i < 31; i++)
					file.ignore(std::numeric_limits<std::streamsize>::max(), ';');
				std::string posnc;
				getline(file, posnc, ';'); //posnc
				if (posnc == "nc")r.status = 3;
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');
				for (int j = 0; file.peek() != '\n'; j++) {
					getline(file, time, ';');
					r.checknr[j] = stoi(time);
					getline(file, time, ';');
					// -----
					if (time == "-----" || time == "0.00")
						r.check[j] = 0;
					else
						r.check[j] = st(time);
				}

				file.get();
				//l.push_back(r);
			}
			else
				file.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
			/*if (*it == r) {
				if (checkandupdate(it, r))
					u.push_back(r);
				it++;
			}
			else {
				l.insert(it, r);
				n.push_back(r);
			}*/
			if(r.lastname!="Üres" && r.lastname!="üres")
				l.push_back(r);
		}
		file.close();
		//töröl
		if (remove("eredmeny.csv") != 0)
			std::cout <<"Error deleting file";
		else
			std::cout << "File successfully deleted";
	}
	catch (std::exception &e) {
		std::cout << e.what() << std::endl;
	}
	std::cout << "read complete" << std::endl;
}
