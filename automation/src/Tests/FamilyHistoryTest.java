package Tests;

import java.io.FileInputStream;
import java.util.ArrayList;
import java.util.List;

import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import Repos.FamilyHistoryPage;
import Repos.LoginPage;
import Repos.medicalHistoryPage;
import Repos.threePanelPage;

public class FamilyHistoryTest {

	WebDriver driver =new FirefoxDriver();;

	private int rowSearch;
	private int rowFamily;
	//search result
	List<String> data = new ArrayList<>();

	//family member
	List<String> family = new ArrayList<>();


	//family history data elements
	@DataProvider(name="familyHistory")
	public static Object[][] dataInputFromExcel() throws Exception
	{

		XSSFWorkbook workBook; 
		XSSFSheet sheet;
		XSSFRow row;
		int i=0;
		int j=0;
		Object[][] DataCellValues;
		List<String> data = new ArrayList<>();
		int rowSearch=0;

		//HashMap<String, String> hmap = new HashMap<String, String>();
		Boolean value = true;
		System.out.println("got here excel");
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("Personal");

		int k=sheet.getLastRowNum();//get the number of rows

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
					System.out.println(DataCellValues[i][j]);
				}


			}
		}
		return DataCellValues;
	}

	//data for seacrh field
	@BeforeMethod
	public void SearchData() throws Exception
	{
		XSSFWorkbook workBook; 
		XSSFSheet sheet;
		XSSFRow row;
		int i=0;
		int j=0;
		short l = 0;
		Object[][] DataCellValues;

		//HashMap<String, String> hmap = new HashMap<String, String>();
		Boolean value = true;
		System.out.println("got here excel data");
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("FamilyHistorySearch");
		System.out.println("got here excel data");
		int k=sheet.getLastRowNum();//get the number of rows
		System.out.println(k);

		int l1=sheet.getRow(rowSearch).getLastCellNum();//get the number of columns in first row
		System.out.println(l1);
		System.out.println(rowSearch);
		if(rowSearch<=k)

		{

			for(int cellNumber=0; cellNumber<l1;cellNumber++)
			{
				//XSSFCell datainput = sheet.getRow(rowSearch).getCell(cellNumber);//get the number of columns in first row

				data.add( new DataFormatter().formatCellValue(sheet.getRow(rowSearch).getCell(cellNumber)));
				System.out.println(data.get(cellNumber));
			}

		}

		rowSearch++;
		System.out.println(rowFamily);




	}
	@BeforeMethod
	public void SearchFamily() throws Exception
	{

		System.out.println("got inside search family");
		XSSFWorkbook workBook; 
		XSSFSheet sheet;
		XSSFRow row;
		int i=0;
		int j=0;
		short l = 0;
		Object[][] DataCellValues;

		//HashMap<String, String> hmap = new HashMap<String, String>();
		Boolean value = true;
		System.out.println("got here excel data");
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("familyRelation");
		System.out.println("got here excel data");
		int k=sheet.getLastRowNum();//get the number of rows
		System.out.println(k);

		int l1=sheet.getRow(rowFamily).getLastCellNum();//get the number of columns in first row
		System.out.println(l1);
		System.out.println(rowFamily);
		if(rowFamily<=k)

		{

			System.out.println("family loop");

			for(int cellNumber=0; cellNumber<l1;cellNumber++)
			{
				System.out.println("family loop cells");
				//XSSFCell datainput = sheet.getRow(rowSearch).getCell(cellNumber);//get the number of columns in first row

				family.add( new DataFormatter().formatCellValue(sheet.getRow(rowFamily).getCell(cellNumber)));
				System.out.println(family.get(cellNumber));
			}

		}

		rowFamily++;
		System.out.println(rowSearch);




	}


	@Test(dataProvider="familyHistory")
	public void getpatientmedical(String uname,String pass,String Patient,String comment,String value
			) throws Exception
	{

		LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys(uname);
		LoginPage.Password(driver).sendKeys(pass);
		LoginPage.Submit(driver).click();


		driver.findElement(By.partialLinkText(Patient)).click();
		Thread.sleep(5000);

		threePanelPage.MedicalHistory(driver).click();

		Thread.sleep(5000);





		for (int familycount=0;familycount<(family.size()/2);familycount++)
		{


			System.out.println("got inside gamily member add");
			FamilyHistoryPage.addFamilyMember(driver).click();

			System.out.println(family.get(0*2));
			System.out.println(family.get((1*2)-1));
			Thread.sleep(5000);
			FamilyHistoryPage.relation(driver).sendKeys(family.get(0));

			if(family.get((1*2)-1).equals("Alive"))
			{
				FamilyHistoryPage.AliveYes(driver).click();
			}
			else
			{
				FamilyHistoryPage.AliveNo(driver).click();
			}

			searchfield();


			System.out.println(data.size());

			
		FamilyHistoryPage.save(driver).click();
		driver.switchTo().alert().accept();


		}
		data.clear();
		System.out.println(data.size());
		family.clear();
		System.out.println(family.size());


	}
	
	
	
	
	public void searchfield() throws Exception
	{
		for (int j=0;j<data.size();j++)
		{     
			//System.out.println(j);
			FamilyHistoryPage.menuDemographics(driver).sendKeys(data.get(j));

			Thread.sleep(2000);
			List<WebElement> options = driver.findElements(By.xpath("//ul[@id='select2-search_diagnosis_list_family_history-results']/li"));
			// Loop through the options and select the one that matches
			Thread.sleep(2000);
			int i=0;
			System.out.println(options.size()+"option size");	
			for (i=0;i<options.size();i++)
			{
				System.out.println("got inside option ");

				System.out.println(options.get(i).getText()+i);

				if(options.get(i).getText().equals("No results found"))
				{
					System.out.println("inside not found");
					FamilyHistoryPage.menuDemographics(driver).clear();
					break;
				}
				else {
					String option=data.get(j);
					Thread.sleep(2000);
					if (options.get(i).getText().equals(option)) {
						System.out.println("got here");
						options.get(i).sendKeys(Keys.ENTER);
						break;
					}
					else
					{
						options.get(i).sendKeys(Keys.ARROW_DOWN);
					}

				}

			}

			System.out.println("family hisotry save");

		}
	}

}











